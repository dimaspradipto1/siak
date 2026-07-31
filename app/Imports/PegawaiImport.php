<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PegawaiImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        if (empty($row['nip']) || empty($row['nama_lengkap'])) {
            return null;
        }

        $nip = $row['nip'];
        $role = strtolower($row['role'] ?? 'pegawai');
        $jabatan = ucwords($role);
        $status = $row['status'] ?? 'Aktif';

        // 1. Process User Account
        $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($nip));
        $email = $row['email'] ?? ($username . '@gmail.com');

        $user = User::where('username', $username)->orWhere('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $row['nama_lengkap'],
                'username' => $username,
                'email' => $email,
                'password' => Hash::make('password'),
                'roles' => $role,
                'is_active' => $status === 'Aktif',
            ]);
        } else {
            $user->update([
                'name' => $row['nama_lengkap'],
                'roles' => $role,
                'is_active' => $status === 'Aktif',
            ]);
        }

        // 2. Parse Date of Birth
        $tglLahir = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                if (is_numeric($row['tanggal_lahir'])) {
                    $tglLahir = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']))->format('Y-m-d');
                } else {
                    $tglLahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $tglLahir = date('Y-m-d');
            }
        } else {
            $tglLahir = date('Y-m-d');
        }

        // 3. Create or Update Pegawai
        $pegawai = Pegawai::updateOrCreate(
            ['nip' => $nip],
            [
                'user_id' => $user->id,
                'nama_pegawai' => $row['nama_lengkap'],
                'jenis_kelamin' => $row['jenis_kelamin'] ?? 'Laki-laki',
                'tempat_lahir' => $row['tempat_lahir'] ?? '',
                'tgl_lahir' => $tglLahir,
                'jabatan' => $jabatan,
                'golongan' => $row['golongan'] ?? null,
                'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
                'status' => $status,
                'agama' => $row['agama'] ?? 'Islam',
                'nomor_wa' => $row['no_whatsapp'] ?? null,
                'alamat' => $row['alamat_lengkap'] ?? null,
            ]
        );

        // 4. Create/Update Guru if role is guru or wali kelas
        if (in_array(strtolower($role), ['guru', 'wali kelas'])) {
            Guru::updateOrCreate(
                ['pegawai_id' => $pegawai->id],
                [
                    'nip_guru' => $pegawai->nip,
                    'golongan' => $pegawai->golongan ?: 'Non-ASN',
                    'pendidikan_terakhir' => $pegawai->pendidikan_terakhir ?: 'S1',
                ]
            );
        }

        return $pegawai;
    }

    public function rules(): array
    {
        return [
            'nip'          => 'required',
            'nama_lengkap' => 'required|string',
        ];
    }
}
