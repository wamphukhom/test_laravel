<?php

use App\Http\Controllers\AboutController; // นำเข้ามาด้วย
use App\Http\Controllers\AdminController; // นำเข้ามาด้วย
use Illuminate\Support\Facades\Route;
use App\Models\User;
// use Illuminate\Support\Facades\DB;
use App\http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;

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
})->name('home');

// การสร้าง Rounte
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/member', function () {
    return view('index');
});

Route::get('/admin', [AdminController::class, 'adminindex'])->middleware('check');

Route::get('/users/{name}&{lname}', function ($name, $lname) {
    echo "HELLO $name $lname";
})->name('users');

// มาจาก libery

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // $users=User::all(); // มาจาก model user use App\Models\User;
        // $users = DB::table('users')->get(); // use Illuminate\Support\Facades\DB;
        $users = User::paginate(1);
        return view('dashboard', compact('users'));
    })->name('dashboard');

    //department
    Route::get('/department/all', [DepartmentController::class, 'index'])->name('department');
    Route::post('/department/add', [DepartmentController::class, 'store'])->name('addDepartment');
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit']);
    Route::post('/department/update/{id}', [DepartmentController::class, 'update']);

    //softdelete
    Route::get('/department/softdelete/{id}', [DepartmentController::class, 'softdelete']);
    Route::get('/department/restore/{id}', [DepartmentController::class, 'restore']);
    Route::get('/department/delete/{id}', [DepartmentController::class, 'delete']);

    //service
    Route::get('/service/all', [ServiceController::class, 'index'])->name('services');
    Route::post('/service/add', [ServiceController::class, 'store'])->name('addService');

    Route::get('/service/edit/{id}', [ServiceController::class, 'edit']);
    Route::post('/service/update/{id}', [ServiceController::class, 'update']);
    Route::get('/service/delete/{id}', [ServiceController::class, 'delete']);

});
