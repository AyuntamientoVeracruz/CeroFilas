<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Pago;
use App\VerifyUser;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/sistema';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:USUARIOS',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      
      /**/  

    }

    protected function redirectPath()
    {
        //if (Auth::user()->role==0) {
          return '/sistema';
      /*  } else {
          return '/home';
        }*/
    }


	/**
     * WEE: Overwrite function to invoke our custome register page.
     */
	public function showRegistrationForm()
	{
		return view('auth.registro');
	}

	/**
     * WEE: Overwrite function so we can use registro on behalf of register.
     */
    public function registro()
    {
        return view('auth.registro');
    }


    /**
       * WEE: methode for verify the user in the DB
       */
   public function verifyUser(string $activationCode)
     {
         try {
             $user = app(User::class)->where('TOKEN', $activationCode)->first();
             if (!$user) {
                 return "The code does not exist for any user in our system.";
             }
             $user->STATUS          = 1;
             $user->TOKEN = null;
             $user->save();
             auth()->login($user);
         } catch (\Exception $exception) {
             logger()->error($exception);
             return $exception;//"Whoops! something went wrong.";
         }
         return redirect()->to('/home');
     }
	 
	 
	 
	 public function showForgotForm()
	 {
		return view('auth.forgot');
	 }
	
	
	/**
     * Reset password (send an email with a new password)
     *
     * @param  array  $data
     * @return \App\User
     */
    public function resetPassword(Request $request)
    {
		$user = User::where('email',$request->email)->first();		        
		
		if($user){
			$newpass = str_random(8);
			$user->password = bcrypt($newpass);			
			$user->save();
        	Mail::to($request->email)->send(new ResetMail($user,$newpass));
			return redirect('/forgot')->with('message', 'Te envíamos un mail con tu nuevo password. Puede estar en la bandeja de Spam.');
		}
		else{
			return redirect('/forgot')->with('message', 'Este email no esta registrado.');
		}
    }


    /**
     * Request Valoracion (send an email with a request of valoracion)
     *
     * @param  array  $data
     * @return \App\User
     */
    public function requestValoracion($turno=false,$foliovaloracion=false)
    {                    
        Mail::to($turno->email)->send(new RequestValoracion($turno,$foliovaloracion));
        if(count(Mail::failures()) == 0){   
            return "true";
        }
        else{
            return "false";    
        }       
    }
	
	
}
