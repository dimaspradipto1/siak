<?php

namespace App\DataTables;

use App\Models\Pengumuman;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class PengumumanDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user', function ($p) {
                return $p->user ? $p->user->name : '-';
            })
            ->addColumn('keterangan_short', function ($p) {
                return \Str::limit($p->keterangan, 50);
            })
            ->addColumn('created_at', function ($p) {
                return \Carbon\Carbon::parse($p->created_at)->locale('id')->translatedFormat('l, d F Y');
            })
            ->addColumn('tahun_ajaran', function ($p) {
                return $p->tahunAjaran ? $p->tahunAjaran->tahun_mulai . '/' . $p->tahunAjaran->tahun_selesai : '-';
            })
            ->addColumn('semester', function ($p) {
                return $p->semester ? $p->semester->nama_semester : '-';
            })
            ->addColumn('kelas', function ($p) {
                return $p->kelas ? $p->kelas->nama_kelas : 'Semua Kelas';
            })
            ->addColumn('mata_pelajaran', function ($p) {
                return $p->mataPelajaran ? $p->mataPelajaran->nama_mata_pelajaran : 'Semua Mapel';
            })
            ->addColumn('action', function ($p) {
                if (in_array(auth()->user()->roles, ['siswa', 'orang tua'])) return '';
                return '
                <div class="d-flex gap-1 justify-content-center">
                    <a href="' . route('pengumuman.edit', $p->id) . '" class="btn btn-warning btn-sm" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="' . route('pengumuman.destroy', $p->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm btn-hapus" data-nama="' . e($p->judul) . '" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(Pengumuman $model): QueryBuilder
    {
        return $model->newQuery()->with(['user', 'tahunAjaran', 'semester', 'kelas', 'mataPelajaran']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pengumuman-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('judul')->title('Judul'),
            Column::make('keterangan_short')->title('Isi Pengumuman')->searchable(false)->orderable(false),
            Column::make('user')->title('Dipublikasikan Oleh')->searchable(false)->orderable(false),
            Column::make('created_at')->title('Tanggal Dibuat'),
            Column::make('tahun_ajaran')->title('Tahun Ajaran')->searchable(false)->orderable(false),
            Column::make('semester')->title('Semester')->searchable(false)->orderable(false),
            Column::make('kelas')->title('Kelas')->searchable(false)->orderable(false),
            Column::make('mata_pelajaran')->title('Mapel')->searchable(false)->orderable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-start'),
        ];
    }

    protected function filename(): string
    {
        return 'Pengumuman_' . date('YmdHis');
    }
}
