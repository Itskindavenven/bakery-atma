<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pegawai;
use App\Models\Role;
Use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\MailSend;
use Illuminate\Validation\Rule;
use Session;
class RegistPegawaiController extends Controller
{
    public function register()
    {
        $roles = Role::all();
        return view('registration.registPeg', compact('roles'));
    }
    public function actionRegister(Request $request) {
        // Validate input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'id_role' => 'required|integer',
            'email' => [
                'required',
                'email',
                Rule::unique('pegawai'), // Email harus unik di dalam tabel 'pegawai'
            ],
            'username' => [
                'required',
                'string',
                Rule::unique('pegawai'), // Username harus unik di dalam tabel 'pegawai'
            ],
            'password' => 'required|string|min:8',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // Unprocessable Entity
        }
    
        $validatedData = $validator->validated();
    
        try {
            // Generate random string for verification
            $str = Str::random(100);
    
            // Hash the password before storing
            $hashedPassword = Hash::make($validatedData['password']);
    
            // Create new employee
            $user = Pegawai::create([
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'id_role' => $validatedData['id_role'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => $hashedPassword, // Store hashed password
                'verify_key' => $str,
            ]);
    
            // Details for email verification
            $details = [
                'username' => $validatedData['username'],
                'website' => 'Atma Bakery',
                'datetime' => now()->format('Y-m-d H:i:s'), // Corrected date format
                'url' => 'http://' . request()->getHttpHost() . '/register/verifypegawai/' . $str // Corrected URL format
            ];
    
            // Send verification email
            Mail::to($validatedData['email'])->send(new MailSend($details));
    
            // Return success response
            Session::flash('message', 'Link verifikasi telah dikirim ke email anda. Silahkan cek email anda untuk mengaktifkan akun.');
            return route('index-pegawai');
    
        } catch (\Exception $e) {
            // Handle unexpected errors
            Session::flash('message', 'Terjadi kesalahan saat proses pendaftaran. Silakan coba lagi.');
            return redirect('register');
        }
    }
    public function verify($verify_key){
        $keyCheck = pegawai::select('verify_key')
        ->where('verify_key', $verify_key)
        ->exists();

        if($keyCheck){
            $user = pegawai::where('verify_key',$verify_key)
                ->update([
                    'active' => 1,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]);
            
                return view('registration.succes');
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Keys tidak valid.'
            ], 404);
        }
    }
}
