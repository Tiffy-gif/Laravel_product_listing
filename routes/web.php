<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

Route::middleware('auth')->group(function () {
  Route::get('/', [ProductController::class, 'home'])->name('products.index');
  Route::get('/create', [ProductController::class, 'createProduct'])->name('product.create');
  Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
  Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
  Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
  Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
  Route::get('/register', [UserController::class, 'create'])->name('register.form');
  Route::post('/register', [UserController::class, 'createUser'])->name('register');
  Route::get('/users', [UserController::class, 'user'])->name('users.user');

  Route::get('/users', [UserController::class, 'user'])->name(name: 'users.user');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
  Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

  Route::resource('categories', CategoryController::class);
  Route::get('/category/category', [CategoryController::class, 'index'])->name('category.index');
});

Route::middleware('guest')->group(function () {
  Route::get('/login', [UserController::class, 'loginForm'])->name('login');
  Route::post('/login', [UserController::class, 'login']);
});

Route::post('/logout', function () {
  Auth::logout();
  request()->session()->invalidate();
  request()->session()->regenerateToken();
  return redirect('/login');
})->middleware('auth')->name('logout');
