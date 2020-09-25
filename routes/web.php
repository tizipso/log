<?php

use Dcat\Admin\Extension\Logs\Http\Controllers;

Route::prefix('logs')->group(function() {
    Route::get('', Controllers\LogsController::class.'@index');
    Route::get('{file}', 'Dcat\Admin\Extension\Logs\Http\Controllers\LogsController@index')->name('log-viewer-file');
    Route::get('{file}/tail', 'Dcat\Admin\Extension\Logs\Http\Controllers\LogsController@tail')->name('log-viewer-tail');
}); 
