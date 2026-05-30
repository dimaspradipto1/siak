<?php

namespace App\DataTables;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SiswaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('tanggal_lahir', function($siswa) {
                return $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-';
            })
            ->addColumn('kelas_nama', function ($siswa) {
                return $siswa->kelas ? $siswa->kelas->nama_kelas : '-';
            })
            ->addColumn('orang_tua', function ($siswa) {
                return $siswa->orangTua ? ($siswa->orangTua->nama_ayah ?? $siswa->orangTua->nama_ibu ?? '-') : '-';
            })
            ->addColumn('ekskul', function ($siswa) {
                return $siswa->ekstrakurikuler ? $siswa->ekstrakurikuler->nama_ekskul : '-';
            })
            ->addColumn('action', function ($siswa) {
                if (!in_array(auth()->user()->roles, ['admin', 'kepala sekolah'])) return '';
                return '
                <div class="d-flex gap-1 justify-content-center">
                    <a href="' . route('siswa.edit', $siswa->id) . '" class="btn btn-warning btn-sm" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="' . route('siswa.destroy', $siswa->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm btn-hapus" data-nama="' . e($siswa->nama_siswa) . '" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(Siswa $model): QueryBuilder
    {
        return $model->newQuery()->with(['kelas', 'orangTua', 'ekstrakurikuler']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('siswa-table')
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
            Column::make('nisn')->title('NISN'),
            Column::make('nama_siswa')->title('Nama Siswa'),
            Column::make('jenis_kelamin')->title('L/P'),
            Column::make('kelas_nama')->title('Kelas')->searchable(false)->orderable(false),
            Column::make('orang_tua')->title('Orang Tua')->searchable(false)->orderable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-start'),
        ];
    }

    protected function filename(): string
    {
        return 'Siswa_' . date('YmdHis');
    }
}
