<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\Borrow;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    /**
     * Show the registration form.
     */
    
    public function index()
    {
        $users = User::with('borrows')->get();
        return view('dashboard.user.index', compact('users'));
    }
    public function create()
    {
        return view('auth.register');
    }

    // public function sendOtp(Request $request)
    // {

    //     $email = $request->query('email'); // استلام البريد من الرابط

    //     $otp = rand(100000, 999999);

    //     Otp::updateOrCreate(
    //         ['email' => $request->email],
    //         ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
    //     );

    //     Mail::to($request->email)->send(new SendOtpMail($otp));
    //     session(['email' => $request->email]);
    //     return response()->json(['message' => 'OTP has been sent to your email.'], 200);
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $request->session()->regenerate();

        if ($validator->fails()) {
            return  back()->with('error', 'Invalid validator');
           
        }

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

          
        return redirect()->route('home');

    }

    // public function verifyOtp(Request $request)
    // {
     

    //     $otp = $request->input('otp');

    //     if (is_array($otp)) {
    //         $otp = implode('', $otp); 
    //     }

    //     $otpRecord = Otp::where('email', $request->email)
    //         ->where('otp', $otp)
    //         ->first();

    //     if (!$otpRecord || now()->greaterThan($otpRecord->expires_at)) {
    //         return response()->json(['message' => 'رمز التحقق غير صالح أو منتهي الصلاحية'], 422);
    //     }

        
    //     $user = User::where('email', $request->email)->first();
    //     $user->email_verified_at = now();
    //     $user->save();

     
    //     $otpRecord->delete();

        
    //     return redirect()->route('home')->with('success', 'تم التحقق بنجاح!');
    // }


    /**
     * Show the login form.
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->with('error', 'Invalid credentials');
    }


    /**
     * Log out the user.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
    /**
     * Display the user's profile.
     */
    public function profile(Request $request)
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }


    public function borrowedBooks(Request $request)
    {
        $user = Auth::user();

        $borrows = $user->borrows()->with('book')->get();
        return view('user.borrowed_books', compact('borrows'));
    }



    public function exportPDF($id)
    {
        $borrow = Auth::user()->borrows()->with('book')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.borrow', compact('borrow'));

        return $pdf->download('borrowed_book_' . $borrow->id . '.pdf');
    }
}
