<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    /**
     * Helper to create a user with a specific role
     */
    private function createUserWithRole($role)
    {
        return User::factory()->create([
            'roles' => $role,
            'password' => bcrypt('password123')
        ]);
    }

    /**
     * Test Admin can access dashboard and data master
     */
    public function test_admin_can_access_dashboard_and_master_data(): void
    {
        $admin = $this->createUserWithRole('admin');

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/siswa');
        $response->assertStatus(200);
    }

    /**
     * Test Kepsek can access dashboard
     */
    public function test_kepsek_can_access_dashboard(): void
    {
        $kepsek = $this->createUserWithRole('kepala sekolah');

        $response = $this->actingAs($kepsek)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test Guru can access dashboard
     */
    public function test_guru_can_access_dashboard(): void
    {
        $guru = $this->createUserWithRole('guru');

        $response = $this->actingAs($guru)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test Wali Kelas can access dashboard
     */
    public function test_wali_kelas_can_access_dashboard(): void
    {
        $wali = $this->createUserWithRole('wali kelas');

        $response = $this->actingAs($wali)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test Siswa can access dashboard
     */
    public function test_siswa_can_access_dashboard(): void
    {
        $siswa = $this->createUserWithRole('siswa');

        $response = $this->actingAs($siswa)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test Orang Tua can access dashboard
     */
    public function test_orang_tua_can_access_dashboard(): void
    {
        $orangTua = $this->createUserWithRole('orang tua');

        $response = $this->actingAs($orangTua)->get('/dashboard');
        $response->assertStatus(200);
    }
}
