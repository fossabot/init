<?php
    
    Route::group(['prefix' => 'auth', 'namespace' => 'AUTH'], function () {
        Route::get('/activation/{code}', 'Activation')
            ->name('auth@activation')
            ->middleware('throttle:5,10');
        Route::post('login', 'Login')
            ->name('auth@login');
        Route::post('forget', 'Forget')
            ->name('auth@forget');
    });
