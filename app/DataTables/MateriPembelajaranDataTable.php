<?php

namespace App\DataTables;

use App\Models\MateriPembelajaran;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MateriPembelajaranDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<MateriPembelajaran> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('deskripsi_short', function ($p) {
                return Str::limit($p->deskripsi_materi, 50);
            })
            ->addColumn('tahun_ajaran', function ($p) {
                return $p->tahunAjaran ? $p->tahunAjaran->tahun_mulai . '/' . $p->tahunAjaran->tahun_selesai : '-';
            })
            ->addColumn('semester', function ($p) {
                return $p->semester ? $p->semester->nama_semester : '-';
            })
            ->addColumn('kelas', function ($p) {
                return $p->kelas ? $p->kelas->nama_kelas : '-';
            })
            ->addColumn('mata_pelajaran', function ($p) {
                return $p->mataPelajaran ? $p->mataPelajaran->nama_mata_pelajaran : '-';
            })
            ->addColumn('diupload_oleh', function ($p) {
                return $p->uploader ? $p->uploader->name : '-';
            })
            ->addColumn('tanggal_upload', function ($p) {
                return Carbon::parse($p->created_at)->locale('id')->translatedFormat('l, d F Y');
            })
            ->addColumn('action', function ($p) {
                $user = auth()->user();
                $buttons = '
                <a href="' . route('materipembelajaran.download', $p->id) . '" class="btn btn-info btn-sm text-white" title="Download">
                    <i class="bi bi-download"></i>
                </a>';

                if ($user && !in_array($user->roles, ['siswa', 'orang tua'])) {
                    $buttons .= '
                    <a href="' . route('materipembelajaran.edit', $p->id) . '" class="btn btn-warning btn-sm" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="' . route('materipembelajaran.destroy', $p->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm btn-hapus" data-nama="' . e($p->judul_materi) . '" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>';
                }

                return '<div class="d-flex gap-1 justify-content-center">' . $buttons . '</div>';
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<MateriPembelajaran>
     */
    public function query(MateriPembelajaran $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['tahunAjaran', 'semester', 'kelas', 'mataPelajaran', 'uploader']);

        if ($this->request()->has('tahun_ajaran_id') && $this->request()->get('tahun_ajaran_id') != '') {
            $query->where('tahun_ajaran_id', $this->request()->get('tahun_ajaran_id'));
        }
        if ($this->request()->has('semester_name') && $this->request()->get('semester_name') != '') {
            $query->whereHas('semester', function ($q) {
                $q->where('nama_semester', $this->request()->get('semester_name'));
            });
        }
        if ($this->request()->has('kelas_id') && $this->request()->get('kelas_id') != '') {
            $query->where('kelas_id', $this->request()->get('kelas_id'));
        }
        if ($this->request()->has('nama_mata_pelajaran') && $this->request()->get('nama_mata_pelajaran') != '') {
            $query->whereHas('mataPelajaran', function ($q) {
                $q->where('nama_mata_pelajaran', $this->request()->get('nama_mata_pelajaran'));
            });
        }

        // Role-based visibility
        $user = auth()->user();
        if ($user && $user->roles === 'siswa') {
            $siswa = Siswa::query()->where('user_id', $user->id)->first();
            if ($siswa) {
                $query->where('kelas_id', $siswa->kelas_id);
            } else {
                $query->whereRaw('1 = 0'); // No access if student profile not found
            }
        } elseif ($user && $user->roles === 'orang tua') {
            $orangTua = OrangTua::query()->where('user_id', $user->id)->first();
            if ($orangTua) {
                $kelasIds = $orangTua->siswa()->pluck('kelas_id');
                $query->whereIn('kelas_id', $kelasIds);
            } else {
                $query->whereRaw('1 = 0'); // No access if parent profile not found
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('materipembelajaran-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax('', 'data.tahun_ajaran_id = $("#tahun_ajaran_id").val(); data.semester_name = $("#semester_name").val(); data.kelas_id = $("#kelas_id").val(); data.nama_mata_pelajaran = $("#nama_mata_pelajaran").val();')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('judul_materi')->title('Judul Materi'),
            Column::make('deskripsi_short')->title('Deskripsi Materi')->searchable(false)->orderable(false),
            Column::make('tahun_ajaran')->title('Tahun Ajaran')->searchable(false)->orderable(false),
            Column::make('semester')->title('Semester')->searchable(false)->orderable(false),
            Column::make('kelas')->title('Kelas')->searchable(false)->orderable(false),
            Column::make('mata_pelajaran')->title('Mata Pelajaran')->searchable(false)->orderable(false),
            Column::make('diupload_oleh')->title('Diupload Oleh')->searchable(false)->orderable(false),
            Column::make('tanggal_upload')->title('Tanggal Upload')->searchable(false)->orderable(false),
            Column::make('file_size')->title('Ukuran File'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MateriPembelajaran_' . date('YmdHis');
    }
}
