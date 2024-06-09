<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\customer;
use App\Models\pegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request){
        return view('login.login');
    }
    public function home(Request $request){
        return view('/home');
    }
    public function homeAdmin(){
        return view('admin.home-admin');
    }
    public function homeMo(){
        return view('mo.home-mo');
    }
    public function actionLogin(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if($credentials['email'] == 'admin' && $credentials['password'] == 'admin') {
            return view('/home-admin');
        }

        if (Auth::guard('customer')->attempt($credentials)) {
            $user = Auth::guard('customer')->user();
            session(['customer' => $user]);
            return view('customer.home');
        } else if (Auth::guard('pegawai')->attempt($credentials)) {
            $user = Auth::guard('pegawai')->user();
            session(['pegawai' => $user]);

            if ($user->id_role == 1) {
                return redirect()->route('home-admin');
            } else if ($user->id_role == 2) {
                return redirect()->route('home-mo');
            } else if ($user->id_role == 0) {
                return redirect()->route('home-owner');
            }
        }else {
            // Menyimpan pesan error ke session
            Session::flash('error', 'Email atau password salah.');
            return redirect()->back();
        }
    }
    public function actionLogoutPegawai(Request $request)
    {
        $request->user('pegawai')->tokens()->delete();
    
        Auth::guard('pegawai')->logout();
    
        return view('login.login');
    }

    public function actionLogoutCustomer(Request $request)
    {
        // Revoke the access token of the authenticated pegawai
        $request->user('customer')->tokens()->delete();
    
        // Logout the authenticated pegawai
        Auth::guard('customer')->logout();
    
        return view('login.login');
    }
}
