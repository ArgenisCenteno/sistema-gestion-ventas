<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            return redirect()->intended('/home');
        }

        // Autenticación fallida
        return back()->withInput()->withErrors(['error' => 'Credenciales incorrectas']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cedula' => 'required|numeric|unique:users,cedula',
            'email' => 'required|email|unique:users,email',
            'sector' => 'nullable|string|max:255',
            'calle' => 'nullable|string|max:255',
            'casa' => 'nullable|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'dni' => $request->cedula,
            'email' => $request->email,
            'sector' => $request->sector,
            'calle' => $request->calle,
            'casa' => $request->casa,
            'password' => Hash::make($request->password), // Hash the password
            'status' => 'Activo', // Set the status
        ]);

      
        $user->assignRole('empleado');

        // Log in the user
        Auth::login($user);

        // Redirect to intended page after successful registration
        return redirect()->intended('/home');
    }
}
