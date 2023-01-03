<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'GISMobileController@login');
Route::get('/validasi', 'GISMobileController@validasiperiodsp');
Route::get('/validasi', [
  'as'   => 'gismobile.validasi',
  'uses' => 'GISMobileController@validasiperiodsp'
]);
Route::get('/halaman', [
  'as' => 'gismobile.index',
  'uses'=>'GISMobileController@gismobile__index'
]);

Auth::routes();
Route::get('auth/verify/{token}', 'Auth\RegisterController@verify');
Route::get('auth/send-verification', 'Auth\RegisterController@sendVerification');

Route::get('/home', 'HomeController@index');
Route::get('settings/profile', 'SettingsController@profile');
Route::get('settings/profile/edit', 'SettingsController@editProfile');
Route::post('settings/profile', 'SettingsController@updateProfile');
Route::get('settings/password', 'SettingsController@editPassword');
Route::post('settings/password', 'SettingsController@updatePassword');

Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']], function () {
  Route::resource('authors', 'AuthorsController');
  Route::resource('books', 'BooksController');
  Route::resource('members', 'MembersController');
  Route::get('statistics', [
    'as'   => 'statistics.index',
    'uses' => 'StatisticsController@index'
  ]);
  Route::get('export/books', [
    'as'   => 'export.books',
    'uses' => 'BooksController@export'
  ]);
  Route::post('export/books', [
    'as'   => 'export.books.post',
    'uses' => 'BooksController@exportPost'
  ]);
  Route::get('template/books', [
    'as'   => 'template.books',
    'uses' => 'BooksController@generateExcelTemplate'
  ]);
  Route::post('import/books', [
    'as'   => 'import.books',
    'uses' => 'BooksController@importExcel'
  ]);
});

Route::get('books/{book}/borrow', [
  'middleware' => ['auth', 'role:member'],
  'as'         => 'guest.books.borrow',
  'uses'       => 'BooksController@borrow'
]);

Route::put('books/{book}/return', [
  'middleware' => ['auth', 'role:member'],
  'as'         => 'member.books.return',
  'uses'       => 'BooksController@returnBack'
]);

Route::group(['prefix' => 'scansp'], function() {
  Route::get('', [
    'as' => 'gismobile.scansp',
    'uses' => 'GISMobileController@supplyproduksi__scan'
  ]);
  Route::get('dt', [
    'as' => 'gismobile.scansp.dt',
    'uses' => 'GISMobileController@supplyproduksi__dt'
  ]);
  Route::get('no-trans/{param1}', [
    'as' => 'gismobile.scansp.no_tr',
    'uses' => 'GISMobileController@supplyproduksi__norut_trans'
  ]);
  Route::get('generate-trans', [
    'as' => 'gismobile.scansp.gen_trans',
    'uses' => 'GISMobileController@supplyproduksi__gen_trans'
  ]);
  Route::get('generate-barang', [
    'as' => 'gismobile.scansp.gen_brg',
    'uses' => 'GISMobileController@supplyproduksi__gen_barang'
  ]);
  Route::post('store', [
    'as' => 'gismobile.scansp.store',
    'uses' => 'GISMobileController@supplyproduksi__store'
  ]);
  Route::get('delete/{param1}', [
    'as' => 'gismobile.scansp.delete',
    'uses' => 'GISMobileController@supplyproduksi__delete'
  ]);
  Route::get('/excel_supplyproduksi', [
    'as' => 'gismobile.scansp.excel_supply_produksi',
    'uses' => 'GISMobileController@excel_supply_produksi'
  ]);
  Route::get('/print_excel/{param1}/{param2}/{param3}/{param4}', [
    'as' => 'gismobile.scansp.print_supply_produksi',
    'uses' => 'GISMobileController@print_supply_produksi'
  ]);
});
Route::group(['prefix' => 'customer'], function() {
  Route::get('', [
    'as' => 'gismobile.customer',
    'uses' => 'GISMobileController@customer'
  ]);
  Route::get('dt', [
    'as' => 'gismobile.customer.dt',
    'uses' => 'GISMobileController@customer__dt'
  ]);
  Route::post('store', [
    'as' => 'gismobile.customer.store',
    'uses' => 'GISMobileController@customer__store'
  ]);
  Route::get('delete/{param1}', [
    'as' => 'gismobile.customer.delete',
    'uses' => 'GISMobileController@customer__delete'
  ]);
});
Route::group(['prefix' => 'produk'], function() {
  Route::get('', [
    'as' => 'gismobile.produk',
    'uses' => 'GISMobileController@produk'
  ]);
  Route::get('dt', [
    'as' => 'gismobile.produk.dt',
    'uses' => 'GISMobileController@produk__dt'
  ]);
  Route::post('store', [
    'as' => 'gismobile.produk.store',
    'uses' => 'GISMobileController@produk__store'
  ]);
  Route::get('delete/{param1}', [
    'as' => 'gismobile.produk.delete',
    'uses' => 'GISMobileController@produk__delete'
  ]);
});
Route::group(['prefix' => 'masuk'], function() {
  Route::get('', [
    'as' => 'gismobile.masuk',
    'uses' => 'GISMobileController@masuk'
  ]);
  Route::get('dt/{param1}/{param2}/{param3}/{param4}/{param5}', [
    'as' => 'gismobile.masuk.dt',
    'uses' => 'GISMobileController@masuk__dt'
  ]);
  Route::get('popup', [
    'as' => 'gismobile.masuk.modal',
    'uses' => 'GISMobileController@invoice__popup_produk'
  ]);
  Route::get('generate', [
    'as' => 'gismobile.masuk.gen_trans',
    'uses' => 'GISMobileController@invoice__gen_supp'
  ]);
  Route::post('store/masuk', [
    'as' => 'gismobile.masuk.store',
    'uses' => 'GISMobileController@masuk__store'
  ]);
  Route::get('delete/{param1}', [
    'as' => 'gismobile.masuk.delete',
    'uses' => 'GISMobileController@masuk__delete'
  ]);
  Route::get('print_masuk/{param1}/{param2}/{param3}/{param4}/{param5}', [
    'as' => 'gismobile.masuk.print',
    'uses' => 'GISMobileController@masuk__print'
]);
Route::get('pdf_masuk/{param1}', [
  'as' => 'gismobile.masuk.pdf',
  'uses' => 'GISMobileController@masuk__pdf'
]);
});
Route::group(['prefix' => 'keluar'], function() {
  Route::get('', [
    'as' => 'gismobile.keluar',
    'uses' => 'GISMobileController@keluar'
  ]);
  Route::get('dt/{param1}/{param2}/{param3}/{param4}/{param5}', [
    'as' => 'gismobile.keluar.dt',
    'uses' => 'GISMobileController@keluar__dt'
  ]);
  Route::get('generate', [
    'as' => 'gismobile.keluar.gen_trans',
    'uses' => 'GISMobileController@keluar__gen_supp'
  ]);
  Route::get('generate/qty', [
    'as' => 'gismobile.keluar.gen_qty',
    'uses' => 'GISMobileController@keluar__gen_qty'
  ]);
  Route::post('store/keluar', [
    'as' => 'gismobile.keluar.store',
    'uses' => 'GISMobileController@keluar__store'
  ]);
  Route::get('delete/{param1}', [
    'as' => 'gismobile.keluar.delete',
    'uses' => 'GISMobileController@keluar__delete'
  ]);
  Route::get('print_keluar/{param1}/{param2}/{param3}/{param4}/{param5}', [
    'as' => 'gismobile.keluar.print',
    'uses' => 'GISMobileController@keluar__print'
]);
});
Route::group(['prefix' => 'surat'], function() {
  Route::get('', [
    'as' => 'gismobile.surat',
    'uses' => 'GISMobileController@surat'
  ]);
  Route::get('input', [
    'as' => 'gismobile.input_surat',
    'uses' => 'GISMobileController@input_surat'
  ]);
  Route::get('dt/{param1}/{param2}/{param3}', [
    'as' => 'gismobile.surat.dt',
    'uses' => 'GISMobileController@surat__dt'
  ]);
  Route::get('popup', [
    'as' => 'gismobile.surat.modal',
    'uses' => 'GISMobileController@popup_surat'
  ]);
  Route::post('store/surat', [
    'as' => 'gismobile.surat.store',
    'uses' => 'GISMobileController@surat_save'
  ]);
  Route::get('print_surat/{param1}', [
    'as' => 'gismobile.surat.print',
    'uses' => 'GISMobileController@surat__print'
]);
});