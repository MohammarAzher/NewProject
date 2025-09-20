<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\LiveLocationController;

use App\Events\MessageSent;


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



Route::get('/send-message', function () {
    // Sending a simple object instead of a model
    $message = [
        'user' => 'John Doe',
        'text' => 'Hello from Laravel Reverb!',
        'timestamp' => now()->toDateTimeString(),
    ];

    // Fire the event
    broadcast(new MessageSent($message));

    return response()->json(['status' => 'Message broadcasted!']);
});
Route::get('/welcome', function () {
    return view('welcome');
})->name('dashboard');


Route::middleware(['auth','role:super-admin|admin'])->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('dashboard');

    ///USERS ROUTES
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/status/update',[UserController::class,'status_update'])->name('user.status.update');



    ///TIME-TABLE ROUTES
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances/fetch', [AttendanceController::class, 'fetch'])->name('attendances.fetch');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    ///ROLES ROUTES
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/givePermissions/{id}', [RoleController::class, 'givePermissions'])->name('role.permissions');
    Route::post('/applyPermissions', [RoleController::class, 'applyPermissions'])->name('role.applyPermissions');

    ///Permissions ROUTES
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::get('/permission/destroy/{id}', [PermissionsController::class, 'destroy'])->name('permission.destroy');
    Route::post('/permission/store', [PermissionsController::class, 'store'])->name('permission.store');



    ///AREAS ROUTES
    Route::get('/areas', [AreaController::class, 'index'])->name('areas');
    Route::post('/area/store', [AreaController::class, 'store'])->name('area.store');
    Route::get('/area/destroy/{id}', [AreaController::class, 'destroy'])->name('area.destroy');


    Route::get('/live-tracking', [LiveLocationController::class, 'index'])->name('live.locations');
    Route::get('/live-tracking-fetch', [LiveLocationController::class, 'liveTracking'])->name('live.locations.fetch');



});
require __DIR__.'/auth.php';
