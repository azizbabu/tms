<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator, Auth, Carbon;

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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

        if($request->isMethod('post')){
            $rules = [
                'email' => 'email|required',
                'password' => 'required|min:6'
            ];
            $validator = Validator::make($request->all(), $rules);
            if (!$validator->fails()) {

                //we are trying to authenticate user via email
                if (Auth::attempt(['email' => trim($request->email), 'password' => $request->password], $request->remember)) {

                    $user = Auth::user();

                    if(!$user->active){
                        Auth::logout();
                        $request->session()->flush();
                        $request->session()->flash('toast', toastMessage('Your account is not active, please contact with your administrator.', 'error'));
                        return view('auth.login')->withInput($request->all());
                    }

                    session()->put([
                        'lastLogin' => Carbon::parse($user->last_login)->format('d M, Y @ h:i:s A'),
                        'date_format'   => getOption('date_format') ? getOption('date_format') : 'Y-m-d',
                    ]);

                    $user->last_login = Carbon::now();
                    $user->save();

                    return redirect()->intended('home');
                }else{
                    session()->flash('toast', toastMessage('Incorect email or password', 'error'));
                    return view('auth.login')->withInput($request->all());
                }
            } else {
                session()->flash('toast', toastMessage('Validation error occurred', 'error'));
                return view('auth.login')->withErrors($validator->errors())->withInput($request->all());
            }
        }else{
            return view('auth.login');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        $request->session()->flash('toast', toastMessage('You have successfully logout!', 'success'));
        return redirect('/login');
    }
}
