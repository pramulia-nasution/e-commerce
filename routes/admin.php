<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' =>'admin.'],function (){
    Route::get('login','AuthController@showFormLogin')->name('login');
    Route::post('login','AuthController@login');
    Route::get('logout','AuthController@logout')->name('logout');

    Route::group(['middleware' => 'auth'],function (){
        Route::get('/','DashboardController@index')->name('dashboard');

        Route::group(['prefix' => 'image', 'as' => 'gambar.'],function (){
            Route::get('/','ImageController@index')->name('index');
            Route::post('/','ImageController@store')->name('store');
            Route::get('/detail/{id}','ImageController@show')->name('show');
            Route::post('delete','ImageController@destroy')->name('destroy');
            Route::post('regenerate','ImageController@regenerate')->name('generate');
            Route::get('settings','ImageController@settings')->name('settings');
            Route::get('size','ImageController@getSizeImage')->name('size');
            Route::post('size','ImageController@postSizeImage')->name('size');
        });

        Route::group(['prefix' => 'katalog'], function (){
            Route::resource('manufacture','ManufactureController')->except('show');
            Route::resource('category','CategoryController')->except('show');
            Route::resource('attribute','AttributeController')->except('show','edit');
            Route::group(['prefix' => 'value', 'as' => 'value.'],function (){
                Route::delete('/{id}','AttributeController@destroyValue');
                Route::get('edit/{id}','AttributeController@editValue');
                Route::post('/','AttributeController@storeValue');
            });
            Route::resource('product','ProductController')->except('show');
            Route::get('product-option/{id}','ProductController@option_product');
            Route::post('update-option','ProductController@option_update');
            Route::get('product/{id}/images','ProductController@product_image');
            Route::get('load-images/{id}','ProductController@load_images');
            Route::post('insert-images','ProductController@insert_image');
            Route::delete('load-images/{id}','ProductController@delete_image');
            Route::resource('coupon','CouponController')->except('show');
        });
        Route::get('logout', 'AuthController@logout')->name('logout');
    });
});

