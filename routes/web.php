<?php

Route::get('reports/admin', 'AdminController@index')->name('reports.admin_index');
Route::get('reports/admin/{admin}', 'Reports/AdminController@show')->name('reports.admin_show');
Route::put('reports/admin/{admin}', 'Reports/AdminController@put')->name('reports.admin_put');
Route::patch('reports/admin/{admin}', 'Reports/AdminController@patch')->name('reports.admin_patch');
Route::delete('reports/admin/{admin}', 'Reports/AdminController@delete')->name('reports.admin_delete');
Route::get('reports/admin', 'AdminController@index')->name('reports.admin_index');
Route::get('reports/admin/{admin}', 'Reports/AdminController@show')->name('reports.admin_show');
Route::put('reports/admin/', 'Reports/AdminController@put')->name('reports.admin_put');
Route::patch('reports/admin/{admin}', 'Reports/AdminController@patch')->name('reports.admin_patch');
Route::delete('reports/admin/{admin}', 'Reports/AdminController@delete')->name('reports.admin_delete');
