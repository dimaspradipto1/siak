<?php

use App\Providers\AppServiceProvider;
use Yajra\DataTables\DataTablesServiceProvider;

return [
    AppServiceProvider::class,
    RealRashid\SweetAlert\SweetAlertServiceProvider::class,
    DataTablesServiceProvider::class,
];
