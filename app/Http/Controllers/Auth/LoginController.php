<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/sistema';
	//home

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	/**
     * WEE: Overwrite function to invoke our custome login pagin.
     */
	public function showLoginForm()
	{
        return view('auth.login');
	}

	/**
     * WEE: This function was added to be able to logout with methode  GET
     */
	public function logout(Request $request) {
        /*	Session::flush();
    		Auth::logout();
    	return redirect('/login');*/
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->estatus!="activo") {
            auth()->logout();
            return back()->with('message', 'Hola, tu cuenta ya no esta activa.');
        }
        if ($user->tipo_user=="tramitador"||$user->tipo_user=="admin_oficina"||$user->tipo_user=="superadmin"){            
             return redirect()->route('sistema');
        }
        if ($user->tipo_user=="kiosko"){            
             return redirect()->route('kiosk');
        }
    }

}
