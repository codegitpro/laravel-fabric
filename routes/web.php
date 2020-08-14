<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	// return redirect()->route('frontendCustomizeTemplaate');
    return view('welcome');
});

Auth::routes();

# Admin Panel/Backend ROutes
Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('dashboard', 'Backend\Dashboard\DashBoardController@index')->name('backendDashboard');
	Route::post('template/delete', 'Backend\Dashboard\DashBoardController@delete')->name('dashboardDeleteTemplate');
	Route::post('template/create', 'Backend\Dashboard\DashBoardController@create')->name('dashboardCreateTemplate');

	Route::get('mapping', 'Backend\Mapping\MappingController@index')->name('backendMapping');
	Route::post('mapping/delete', 'Backend\Mapping\MappingController@delete')->name('backendMappingDelete');
	Route::post('mapping/create', 'Backend\Mapping\MappingController@create')->name('backendMappingCreate');

	Route::get('fonts', 'Backend\Fonts\FontsController@index')->name('backendFonts');
    Route::get('fonts/search', 'Backend\Fonts\FontsController@search')->name('backendFontsSearch');
    Route::post('fonts/delete', 'Backend\Fonts\FontsController@delete')->name('backendFontsDelete');
	Route::post('fonts/create', 'Backend\Fonts\FontsController@create')->name('backendFontsCreate');

    Route::get('logo', 'Backend\Logo\LogoController@index')->name('backendLogo');
    Route::get('logo/search', 'Backend\Logo\LogoController@search')->name('backendLogoSearch');
	Route::post('logo/delete', 'Backend\Logo\LogoController@delete')->name('backendLogoDelete');
	Route::post('logo/create', 'Backend\Logo\LogoController@create')->name('backendLogoCreate');


	Route::get('ready-to-print', 'Backend\ReadyToPrint\ReadyToPrintController@index')->name('backendReadyToPrint');
	Route::get('download-pdf/{orderId}', 'Backend\ReadyToPrint\ReadyToPrintController@downloadPdf')->name('backendReadyToPrintDownloadPdf');
});
Route::post('save-order', 'Frontend\CustomizeTemplate\CustomizeTemplateController@saveOrder')->name('frontendSaveOrder');
 Route::get('customize-template', 'Frontend\CustomizeTemplate\CustomizeTemplateController@index')->name('frontendCustomizeTemplaate');
Route::post('upload-photo', 'Frontend\CustomizeTemplate\CustomizeTemplateController@uploadPhoto')->name('frontendUploadPhooto');

Route::get('/{shopId}/{templateId}/{orderId}', 'Frontend\CustomizeTemplate\CustomizeTemplateController@index')->name('frontendCustomizeTemplaate');
Route::post('/{shopId}/{templateId}/{orderId}', 'Frontend\CustomizeTemplate\CustomizeTemplateController@readyToPrint')->name('frontendCustomizeTemplateReadyToPrint');
