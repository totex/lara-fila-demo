<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('admin');
});

//Route::get('/approval', function () {
//    if (!auth()->user()) {
//        return redirect('admin');
//    }
////    if (auth()->user()->is_admin || auth()->user()->is_approved) {
////        return redirect('admin');
////    }
//    return view('waiting-for-user-approval');
//})->name('approval');
