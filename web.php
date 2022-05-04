//------ Route for Players ------
Route::resource('players', players::class);
   Route::get('/players/destroy/{id}', 'Players@destroy')->name('destroy-player');
                    Route::get('/players'/ajaxField, 'players@ajaxField')->name('ajaxField');
                
