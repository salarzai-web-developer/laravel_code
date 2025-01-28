<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SendEmailControlle;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/',[ProductController::class,'index'])->name('/');
Route::post('/product',[ProductController::class,'store'])->name('product');
Route::get('/getdata',[ProductController::class,'getData'])->name('getData');
Route::post('/delete-item/{id}',[ProductController::class,'deletemethod'])->name('delete');


// Route::post('/edit/{id}',[ProductController::class,'edit'])->name('edit');

Route::post('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
