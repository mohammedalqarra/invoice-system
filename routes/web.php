<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('', [InvoiceController::class, 'index'])->name('index');


Route::get('/invoice/trash', [InvoiceController::class, 'trash'])->name('invoice.trash');
Route::put('invoice/{invoice}/restore', [InvoiceController::class, 'restore'])->name('invoice.restore');
Route::delete('invoice/{invoice}/force-delete', [InvoiceController::class, 'forceDelete'])->name('invoice.force-delete');



Route::resource('/invoice', InvoiceController::class);

// Route::get('change-language/{locale}', ['as' => 'frontend_change_locale', 'uses' => 'GeneralController@changeLanguage']);

Route::get('invoice/print/{id}', [InvoiceController::class, 'print'])->name('invoice.print');

Route::get('invoice/pdf/{id}', [InvoiceController::class, 'pdf'])->name('invoice.pdf');

Route::get('invoice/send_to_email/{id}', [InvoiceController::class, 'send_to_email'])->name('invoice.send_to_email');

Route::get('change-language/{locale}', [GeneralController::class, 'changeLanguage'])->name('frontend_change_locale');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


require __DIR__ . '/dashboard.php';
