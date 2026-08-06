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
            ->addColumn('jenis_kelamin', function ($siswa) {
                return $siswa->jenis_kelamin ?? '-';
            })
            ->addColumn('nama_ortu', function ($siswa) {
                return $siswa->orangTua ? ($siswa->orangTua->nama_ayah ?? $siswa->orangTua->nama_ibu ?? '-') : '-';
            })
            ->addColumn('tempat_lahir', function ($siswa) {
                return $siswa->tempat_lahir ?? '-';
            })
            ->editColumn('tgl_lahir', function ($siswa) {
                return $siswa->tgl_lahir ? \Carbon\Carbon::parse($siswa->tgl_lahir)->locale('id')->translatedFormat('d F Y') : '-';
            })
            ->addColumn('no_wa_ortu', function ($siswa) {
                return $siswa->orangTua ? ($siswa->orangTua->nomor_wa ?? $siswa->orangTua->nomor_wa_ibu ?? '-') : ($siswa->nomor_wa ?? '-');
            })
            ->addColumn('action', function ($siswa) {
                if (auth()->user()?->roles !== 'admin') return '';
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
        return $model->newQuery()->with(['orangTua']);
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
        $cols = [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('nisn')->title('NISN'),
            Column::make('nama_siswa')->title('Nama Siswa'),
            Column::make('jenis_kelamin')->title('Jenis Kelamin'),
            Column::make('nama_ortu')->title('Nama Ortu')->searchable(false)->orderable(false),
            Column::make('tempat_lahir')->title('Tempat Lahir'),
            Column::make('tgl_lahir')->title('Tanggal Lahir'),
            Column::make('no_wa_ortu')->title('No. Wa Ortu')->searchable(false)->orderable(false),
        ];

        if (auth()->user()?->roles === 'admin') {
            $cols[] = Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center');
        }

        return $cols;
    }

    protected function filename(): string
    {
        return 'Siswa_' . date('YmdHis');
    }
}
