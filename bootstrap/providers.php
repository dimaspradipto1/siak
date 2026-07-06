<?php

use App\Providers\AppServiceProvider;
use Yajra\DataTables\DataTablesServiceProvider;
use RealRashid\SweetAlert\SweetAlertServiceProvider;

return [
    AppServiceProvider::class,
    SweetAlertServiceProvider::class,
    DataTablesServiceProvider::class,
];
