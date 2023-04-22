<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TaskController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\CategoryController;

    Route::get('login',[UserController::class,'login'])->name('login');
    Route::post('loginrequest',[UserController::class,'loginrequest'])->name('loginrequest');
    Route::get('loggoutt',[UserController::class,'logout'])->name('logout');
    
    Route::group(["middleware"=>"auth"],function(){
        Route::get('/',[UserController::class,'index'])->name('home');
    });
    Route::group(['prefix'=>"admin/categories","middleware"=>"auth"],function()
    {
        Route::get('/',[CategoryController::class,'index'])->name('categories');
            Route::get('/create',[CategoryController::class,'create'])->name('categories/create');
            Route::post('/store',[CategoryController::class,'store'])->name('categories/store');
            Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('categories/edit');
            Route::post('/update/{id}',[CategoryController::class,'update'])->name('categories/update');
            Route::delete('/delete/{id}',[CategoryController::class,'destroy'])->name('categories/delete');
            
    });
    Route::group(['prefix'=>"admin/project","middleware"=>"auth"],function()
    {
        Route::get('/',[ProjectController::class,'index'])->name('projects');
        Route::get('/create',[ProjectController::class,'create'])->name('project/create');
        Route::post('/store',[ProjectController::class,'store'])->name('project/store');
        Route::get('/edit/{id}',[ProjectController::class,'edit'])->name('project/edit');
        Route::post('/update/{id}',[ProjectController::class,'update'])->name('project/update');
        Route::delete('/delete/{id}',[ProjectController::class,'destroy'])->name('project/delete');
        Route::get('/archive',[ProjectController::class,'trashed'])->name('project/archive');
        Route::get('/restore/{id}',[ProjectController::class,'restore'])->name('project/restore');
    });

    Route::group(['prefix'=>"admin/task","middleware"=>"auth"],function()
    {
        Route::get('/',[TaskController::class,'index'])->name('tasks');
        Route::get('/create',[TaskController::class,'create'])->name('task/create');
        Route::post('/store',[TaskController::class,'store'])->name('task/store');
        Route::get('/edit/{id}',[TaskController::class,'edit'])->name('task/edit');
        Route::post('/update/{id}',[TaskController::class,'update'])->name('task/update');
        Route::delete('/delete/{id}',[TaskController::class,'destroy'])->name('task/delete');
        Route::get('/archive',[TaskController::class,'trashed'])->name('task/archive');
        Route::get('/restore/{id}',[TaskController::class,'restore'])->name('task/restore');
    });