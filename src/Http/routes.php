<?php

Route::group(['prefix' => config('admin.url')], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('banners/trash', ['uses' => 'BannersAdminController@index', 'as' => 'admin.banners.trash']);
        Route::post('banners/restore/{id}', ['uses' => 'BannersAdminController@restore', 'as' => 'admin.banners.restore']);
        Route::get('banners/create/{place}', ['uses' => 'BannersAdminController@create', 'as' => 'admin.banners.create']);
        Route::get('banners/{banners}/edit/{place}', ['uses' => 'BannersAdminController@edit', 'as' => 'admin.banners.edit']);
        Route::resource('banners', 'BannersAdminController', [
            'names' => [
                'index' => 'admin.banners.index',
                /*'create' => 'admin.banners.create',*/
                'store' => 'admin.banners.store',
                /*'edit' => 'admin.banners.edit',*/
                'update' => 'admin.banners.update',
                'show' => 'admin.banners.show',
            ], 'except' => ['create', 'edit', 'destroy']]);
        Route::delete('banners/destroy', ['uses' => 'BannersAdminController@destroy', 'as' => 'admin.banners.destroy']);
    });
});