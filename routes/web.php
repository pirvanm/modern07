<?php

use App\Http\Services\GridDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



// redirect to login page

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware('auth')->get('data', function (Request  $request, GridDataService $dataService) {
    return $dataService->getData($request);
})->name('data');

require __DIR__ . '/auth.php';


// language switch
Route::post('language/{language}', function ($language) {
    Session()->put('locale', $language);

    return redirect()->back();
})->name('language');
