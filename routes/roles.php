<?php
    
    Route::get('/', 'Index');
    Route::post('/', 'Store');
    Route::patch('/restore/all', 'RestoreAll');
    Route::patch('/restore/{user_id}', 'Restore');
    Route::delete('/force/all', 'ForceDestroyAll');
    Route::delete('/force/{user_id}', 'ForceDestroy');
    Route::delete('/{user_id}', 'Destroy');
    Route::get('/{user_id}', 'Show');
    Route::put('/{user_id}', 'Update');
