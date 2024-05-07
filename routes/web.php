<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BotManController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/adminauth.php';

Route::get('/admin/dashboard', function () {
    return view('admin.auth.dashboard');
})->middleware(['auth:admin', 'verified'])->name('admin.dashboard');
/*=============================Users Route======================================*/
Route::get('/admin/users', function () {
    return view('admin.users');
})->name('admin.users');
Route::get('/admin/experts', function () {
    return view('admin.experts');
})->name('admin.experts');
Route::get('/admin/rating', function () {
    return view('admin.rating');
})->name('admin.rating');
Route::get('/admin/password', function () {
    return view('admin.password');
})->name('admin.password');
Route::get('/fetch-users', [UsersController::class, 'fetchUsers']);
Route::delete('/delete-user/{id}', [UsersController::class, 'deleteUser'])->name('delete.user');
Route::get('/infos/user/modal/{id}',[UsersController::class, 'create'])->name('infos.user.modal');
Route::get('/filter-users',[UsersController::class,'filterUsers'])->name('filter.users');
/*=============================Users Route======================================*/
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle'])->withoutMiddleware([VerifyCsrfToken::class]);
