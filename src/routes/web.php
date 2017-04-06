<?php

Route::group(['middleware' => ['web'], 'prefix' => config('admin.url'), 'as' => 'admin.banners'], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('banners/trash', ['uses' => 'BannersAdminController@index', 'as' => '.trash']);
        Route::post('banners/restore/{id}', ['uses' => 'BannersAdminController@restore', 'as' => '.restore']);
        Route::get('banners/create/{place}', ['uses' => 'BannersAdminController@create', 'as' => '.create']);
        Route::get('banners/{banner}/edit/{place}', ['uses' => 'BannersAdminController@edit', 'as' => '.edit']);
        Route::resource('banners', 'BannersAdminController', [
            'names' => [
                'index' => '.index',
                'store' => '.store',
                'update' => '.update',
                'show' => '.show',
            ], 'except' => ['create', 'edit', 'destroy']]);
        Route::delete('banners/destroy', ['uses' => 'BannersAdminController@destroy', 'as' => '.destroy']);
    });
});