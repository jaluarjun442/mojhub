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
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\HomeController;

Route::prefix('admin')->group(function () {
    require base_path('routes/admin.php');
});
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('video/{video_url}', [HomeController::class, 'video_detail'])->name('video_detail');
Route::get('page/{page_no}', [HomeController::class, 'page'])->name('page');
Route::get('category/{category_name}/page/{page_no?}', [HomeController::class, 'category'])->name('category');
