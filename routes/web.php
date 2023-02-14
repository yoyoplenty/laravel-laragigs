<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

/**
 * THIS IS THE LISTING ROUTES
 */

//This gets All listings
Route::get('/', [ListingController::class, 'index']);

//This is to get the show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show Edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update listing 
Route::patch('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//This gets a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);


/**
 * THIS IS THE USERS/AUTHENTICATION ROUTES
 */

//Get User Registration form
Route::get('register', [UserController::class, 'register'])->middleware('guest');

//Create New User
Route::post('/users', [UserController::class, 'store']);

//Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Login User
Route::post('/users/login', [UserController::class, 'authenticate']);


// Route::get('/hello', function () {
//     return response("Hello, world!")
//         ->header('content-type', 'text/plain')
//         ->header('foo', 'bar');
// });

// Route::get('/posts/{id}', function ($id) {
//     return response("Posts " . $id);
// })->where('id', '[0-9]+');

// Route::get('/search', function (Request $request) {
//     return $request->name;
// });
