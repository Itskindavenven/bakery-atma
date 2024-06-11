<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use App\Mail\reset_customer;
use App\Mail\reset_pegawai;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function inputEmailCust(Request $request){
        return view('reset.reset_customer');
    }
    public function actionResetCust(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:customer,email',
            ]);

            // $request->validate([
            //     'email' => 'required|email',
            // ]);
            
            $customer = Customer::where('email', $request->email)->firstOrFail();
    
            // Generate unique token for password reset link
            $token = uniqid();
    
            // Save token to customer record in database
            $customer->password_reset_token = $token;
            $customer->save();
    
            // Send email to customer with password reset link
            $details = [
                'token' => $token,
                'email' => $customer->email,
                'name' => $customer->nama_lengkap, // Adjust accordingly based on your Customer model
            ];
    
            Mail::to($customer->email)->send(new reset_customer($details));
            
            return redirect()->back()->with('success', 'Password reset email sent successfully.');
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again.',
            ], 500);
        }
        
    }
    

    public function showResetFormCust($token)
    {
        $customer = Customer::where('password_reset_token', $token)->first();

        // Periksa apakah token valid
        if (!$customer) {
            return "Token tidak valid.";
        }

        // Anda juga bisa menambahkan validasi apakah token telah kadaluarsa

        // Jika token valid, tampilkan form reset password
        return view('reset.urlpass_customer', ['token' => $token]);
    } 

    public function resetPasswordCust(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);
    
        // Temukan pengguna berdasarkan token yang diberikan
        $user = Customer::where('password_reset_token', $request->token)->first();
    
        if (!$user) {
            // Kembalikan ke view reset_customer.blade.php dengan pesan kesalahan
            return view('reset_customer')->with('error', 'Token reset password tidak valid.');
        }        
    
        // Perbarui kata sandi dan hapus token reset password
        $user->password = Hash::make($request->new_password);
        $user->password_reset_token = null;
        $user->save();
    
        return view('reset.succes');
    }
    public function inputEmailPeg(Request $request){
        return view('reset.reset_employee');
    }
    public function actionResetPeg(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pegawai,email',
        ]);
            $pegawai = pegawai::where('email', $request->email)->firstOrFail();
    
            // Generate unique token for password reset link
            $token = uniqid();
    
            // Save token to customer record in database
            $pegawai->password_reset_token = $token;
            $pegawai->save();
    
            // Send email to customer with password reset link
            $details = [
                'token' => $token,
                'email' => $pegawai->email,
                'name' => $pegawai->nama_lengkap, // Adjust accordingly based on your Customer model
            ];
    
            Mail::to($pegawai->email)->send(new reset_pegawai($details));
            
            // return redirect()->back()->with('success', 'Password reset email sent successfully.');
            return response()->json([
                'status' => 'success',
                'message' => 'Password reset email sent successfully.',
            ], 200);
    }
    

    public function showResetFormPeg($token)
    {
        $pegawai = pegawai::where('password_reset_token', $token)->first();

        // Periksa apakah token valid
        if (!$pegawai) {
            return "Token tidak valid.";
        }

        // Anda juga bisa menambahkan validasi apakah token telah kadaluarsa

        // Jika token valid, tampilkan form reset password
        return view('reset.urlpass_pegawai', ['token' => $token]);
    } 

    public function resetPasswordPeg(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);
    
        // Temukan pengguna berdasarkan token yang diberikan
        $user = pegawai::where('password_reset_token', $request->token)->first();
    
        if (!$user) {
            // Kembalikan ke view reset_customer.blade.php dengan pesan kesalahan
            return view('reset_pegawai')->with('error', 'Token reset password tidak valid.');
        }        
    
        // Perbarui kata sandi dan hapus token reset password
        $user->password = Hash::make($request->new_password);
        $user->password_reset_token = null;
        $user->save();
    
        return view('reset.succes');
    }
}
