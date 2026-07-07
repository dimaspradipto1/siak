<?php

namespace App\DataTables;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MataPelajaranDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('kelas', function ($mapel) {
                return $mapel->kelas ? $mapel->kelas->nama_kelas : '-';
            })
            ->addColumn('tahun_ajaran', function ($mapel) {
                return $mapel->tahunAjaran ? $mapel->tahunAjaran->nama_tahun_ajaran : '-';
            })
            ->addColumn('semester', function ($mapel) {
                return $mapel->semester ? $mapel->semester->nama_semester : '-';
            })
            ->addColumn('nama_guru', function ($mapel) {
                return $mapel->guru && $mapel->guru->pegawai ? $mapel->guru->pegawai->nama_pegawai : '-';
            })
            ->addColumn('action', function ($mapel) {
                if (!in_array(auth()->user()->roles, ['admin', 'kepala sekolah'])) return '';
                return '
                <div class="d-flex gap-1 justify-content-center">
                    <a href="' . route('matapelajaran.show', $mapel->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="' . route('matapelajaran.edit', $mapel->id) . '" class="btn btn-warning btn-sm" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="' . route('matapelajaran.destroy', $mapel->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm btn-hapus" data-nama="' . e($mapel->nama_mata_pelajaran) . '" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(MataPelajaran $model): QueryBuilder
    {
        return $model->newQuery()->with(['kelas', 'tahunAjaran', 'semester', 'guru.pegawai']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('matapelajaran-table')
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
            Column::make('kelas')->title('Kelas'),
            Column::make('tahun_ajaran')->title('Tahun Ajaran'),
            Column::make('semester')->title('Semester'),
            Column::make('nama_mata_pelajaran')->title('Nama Mapel'),
            Column::make('nama_guru')->title('Nama Guru'),
            Column::make('hari_mengajar')->title('Hari Mengajar'),
            Column::make('jam_mengajar')->title('Jam Mengajar'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'MataPelajaran_' . date('YmdHis');
    }
}
