<?php

use App\Http\Controllers\chatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(!isset(auth()->user()->id)){
        return view('auth.login');
    }
    return view('dashboard');
});

Route::get('/users',[UserController::class,"index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->controller(chatController::class)->group(function () {
    Route::get("/chat",'index')->name("chat.index");
    Route::get("/chat/{id}","show")->name("chat.show");
    Route::post("/chat","store")->name("chat.store");
    Route::get("/messages/{id}","messages")->name("chat.messages");
});

require __DIR__.'/auth.php';
