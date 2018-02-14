<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\User;
use Auth, File, Validator;

class UserController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getAccountVarification', 'getResetPassword']]);
    }

    /**
    * Display a profile form and Update profile information
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function profile(Request $request)
    {
    	$user = $request->user();
    	if($request->isMethod('post')) {

    		$rules = array(
	            'full_name'     => 'required|max:255',
	            'password'	=> 'confirmed',
            );

            if($request->hasFile('photo')) {
                $rules['photo'] = 'mimes:jpg,jpeg,png|max:1024';
            }

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
            	
            	return redirect()->back()->withErrors($validator)->withInput();
            }else {
            	// update user data
            	if($request->has('password'))  {
            		$user->password = bcrypt($request->password);
            		$user->save();
            	}

            	// Update employee data
            	$employee = $user->employee;
            	if($employee) {
            		$employee_id = $employee->id;
            	}
            	$employee = $employee ? $employee : new Employee;
            	$employee->full_name = trim($request->full_name);
	            $employee->fathers_name = trim($request->fathers_name);
	            $employee->mothers_name = trim($request->mothers_name);
	            $employee->dob = $request->has('dob') && $request->dob != '0000-00-00' ? trim($request->dob) : null;
	            $employee->religion = trim($request->religion);
	            $employee->nationality = trim($request->nationality);
	            $employee->nid = trim($request->nid);
	            $employee->tin = trim($request->tin);

                /**
                * Upload photo
                */
                $upload_folder = 'uploads/avatar/';
                // check whether folder already exist if not, create folder
                if(!file_exists($upload_folder)) {
                    mkdir($upload_folder, 0755, true);
                }
                // Delete photo from upload folder && database if remove button is pressed and do not upload photo
                if(!empty($employee->photo) && $request->file_remove == 'true' && !$request->hasFile('photo')){
                    $uploaded_photo_name = basename($employee->photo);
                    if(file_exists($upload_folder.$uploaded_photo_name)){
                        File::delete($upload_folder.$uploaded_photo_name);
                        $employee->photo = null;
                    }
                }
                if($request->hasFile('photo')) {
                    // check if photo already exists in database
                    if(!empty($employee->photo)){
                        $uploaded_photo_name = basename($employee->photo);
                        if(file_exists($upload_folder.$uploaded_photo_name)){
                            File::delete($upload_folder.$uploaded_photo_name);
                        }
                    }
                    $photo_name = $request->photo->getClientOriginalName();
                    if(file_exists($upload_folder.$photo_name)){
                        $photo_name = str_replace('.' . $request->photo->getClientOriginalExtension(), '', $request->photo->getClientOriginalName()).mt_rand().'.' . $request->photo->getClientOriginalExtension();
                    }
                    $photo_name = str_replace([' ','_'], '-', strtolower($photo_name));
                    if($request->photo->move($upload_folder, $photo_name)) {
                        $employee->photo = $upload_folder.$photo_name;
                    }
                }
	            if($employee->save()) {
	            	if(empty($employee_id)) {
		            	$user->employee_id = $employee->id;
		            	$user->save();
		            }
		            $message = toastMessage('User info has been successfully updated.', 'success');
	            }else {
	            	 $message = toastMessage('User info has not been updated.', 'error');
	            } 

	            session()->flash('toast', $message);

	            return back();
            }
    	}

    	return view('users.profile', compact('user'));
    }

    /**
     * Handle user account varification for the application.
     *
     * @param string $secret_code         
     * @return \Illuminate\Http\Response
     */
    function getAccountVarification($secret_code) 
    {
        if ($secret_code) {
            try {

				$data = \Firebase\JWT\JWT::decode($secret_code, env('SSO_KEY'), ['HS256']);

			} catch (\Firebase\JWT\ExpiredException $ex) {

				// return response()->json([$ex->getMessage()]);
				$message = toastMessage($ex->getMessage(), 'error');
				session()->flash('toast', $message);

				return redirect('/');

			} catch (\Exception $ex) {

				$message = toastMessage($ex->getMessage(), 'error');
				session()->flash('toast', $message);

				return redirect('/');

			}
			if (empty($data->resource)) {

				$message = toastMessage('Invalid Request', 'error');
				session()->flash('toast', $message);

				return redirect('/');

			}

			if (Auth::loginUsingId($data->resource)) {

				//user is authenticated
                    
                session()->put ( 'name', Auth::user ()->employee->full_name );
                session()->put ( 'role', Auth::user ()->role );
                
                $lastlogin = Auth::user ()->lastlogin != "" ? Auth::user ()->lastlogin : Auth::user ()->created_at;
                session()->put ( 'lastlogin', date ( 'd M, Y @ h:i:s a', strtotime ( $lastlogin ) ) );
                
                $user = User::find ( Auth::user ()->id );
                $user->active = 1;
                $user->last_login = date ( 'Y-m-d H:i:s' );
                $user->save ();

                return redirect( 'home' );
			} else {

				//user is not authenticated
				$message = toastMessage ( 'User is not authenticated', 'error' );
			}
        } else {
            $message = toastMessage ( 'Invalid request.', 'error' );
        }
        session()->flash('toast', $message);
        
        return redirect ( '/' );
    }

    public function getResetPassword(Request $request, $username)
    {
        $user = User::whereUsername($username)->first();
        $user->password = bcrypt(123456);
        $user->active = 1;
        if($user->save()) {
            exit('User password has been reset. Your new password is 123456');
        }else {
            exit('Something wrong!. Please try again.');
        }
    }

    /**
    * Change user access
    *
    * @param  \Illuminate\Http\Request  $request
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function changeActive(Request  $request)
    {
        $user = User::find($request->hdnResource);
        if(!$user) {
            session()->flash('toast', toastMessage('User not found', 'error'));

            return back();
        }

        if($user->active) {
            $user->active = 0;
            $msg = 'deactivated';
        }else {
            $user->active = 1;
            $msg = 'activated';
        }

        if($user->save()) {
            $message = toastMessage(' User has been '.$msg);
        }else {
            $message = toastMessage(' User has not been '.$msg, 'error');
        }

        $request->session()->flash('toast', $message);
        
        return back();
    }
}
