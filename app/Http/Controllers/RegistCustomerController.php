<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
Use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\MailSend;
use Illuminate\Validation\Rule;
use App\Models\alamat;
use Session;
class RegistCustomerController extends Controller
{
    public function register()
    {
        return view('registration.registCust');
    }
    public function actionRegister(Request $request){
        // Validate incoming request data
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email' => [
                'required',
                'email',
                Rule::unique('customer'),
            ],
            'username' => [
                'required',
                'string',
                Rule::unique('customer'),
            ],
            'password' => 'required|string|min:8',
            'alamat' => 'required'
        ]);
    
        // Generate a random string for verification
        $str = Str::random(100);
    
        // Hash the password
        $hashedPassword = Hash::make($validatedData['password']);
    
        // Create a new Customer record
        $customer = Customer::create([
            'nama_lengkap'=> $validatedData['nama_lengkap'],
            'tanggal_lahir'=> $validatedData['tanggal_lahir'],
            'email'=> $validatedData['email'],
            'username'=> $validatedData['username'],
            'password'=> $hashedPassword,
            'verify_key'=> $str,
        ]);

        $alamat = new alamat;
        $alamat->id_customer = $customer->id_customer;
        $alamat->alamat = $request->alamat;
        $alamat->save();
    
        // Prepare data for email verification
        $details = [
            'username' => $validatedData['username'],
            'website' => 'Atma Bakery',
            'datetime' => now()->format('Y-m-d H:i:s'),
            'url'=> 'http://' . request()->getHttpHost() . '/register/verifycustomer/'. $str
        ];
    
        // Send verification email
        Mail::to($validatedData['email'])->send(new MailSend($details));
    
        // Return success response
        Session::flash('message', 'Link verifikasi telah dikirim ke email anda. Silahkan cek email anda untuk mengaktifkan akun.');
        return redirect('register');
    //     $response = [
    //         'status' => 'success',
    //         'message' => 'Link verifikasi telah dikirim ke email anda. Silahkan cek email anda untuk mengaktifkan akun.'
    //     ];
    //     return response()->json($response, 200);
    }
    public function verify($verify_key){
        $keyCheck = customer::select('verify_key')
        ->where('verify_key', $verify_key)
        ->exists();

        if($keyCheck){
            $user = customer::where('verify_key',$verify_key)
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
