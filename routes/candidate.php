<?php

/*Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('candidate')->user();

    //dd($users);

    return view('candidate.home');
})->name('home');*/

Route::get('/home', 'CandidateHomeController@index')->name('home');



