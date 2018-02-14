<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Helpers\Classes\EmailSender;
use App\Branch;
use App\Company;
use App\Country;
use App\Department;
use App\Designation;
use App\Employee;
use App\User;
use Carbon, File, Validator;

class CompanyController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Company::query();
        if(!isSuperAdmin()){
            $query->whereCreatedBy($request->user()->id);
        }
        $companies = $query->latest('id')->paginate(10);
        $companies->paginationSummery = getPaginationSummery($companies->total(), $companies->perPage(), $companies->currentPage());

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'country_code')->prepend('Select a Country', '')->all();
        
        return view('companies.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'title'         => 'required|unique:companies,title'.($request->has('company_id') ? ','.$request->company_id : ''),
            'country'     => 'required|max:10',
            'state'     => 'required|max:50',
            'city'     => 'required|max:50',
            'zip'     => 'required|max:50',
            'address'     => 'required',
        );
        if($request->hasFile('logo')) {
            $rules['logo'] = 'mimes:jpg,jpeg,png|max:1024';
        }

        if(!$request->has('company_id')) {
            $rules = $rules + [
                'branch_title'         => 'required',
                'branch_country'   => 'required|max:10',
                'branch_state'     => 'required|max:50',
                'branch_city'     => 'required|max:50',
                'branch_zip'     => 'required|max:50',
                'branch_address'     => 'required',
                'department_title'     => 'required',
                'designation_title'  => 'required',
                'full_name'     => 'required|max:255',
                'gender'     => 'required|max:20',
                'phone'     => 'required|max:50',
                'email' => 'required|email|string|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                // 'role'  => 'required|string',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            // store
            $company = !$request->has('company_id') ? new Company : Company::findOrFail($request->company_id);
            $company->title = trim($request->title);
            $company->slug = trim($request->title);
            $company->description = trim($request->description);
            $company->contact_person_name = trim($request->contact_person_name);
            $company->contact_person_phone = trim($request->contact_person_phone);
            $company->contact_person_email = trim($request->contact_person_email);
            $company->established_year = $request->has('established_year') ? trim($request->established_year) : null;
            $company->address = trim($request->address);
            $company->city = trim($request->city);
            $company->state = trim($request->state);
            $company->zip = trim($request->zip);
            $company->country = trim($request->country);
            /**
            * Upload logo
            */
            $upload_folder = 'uploads/company-logo/';
            // check whether folder already exist if not, create folder
            if(!file_exists($upload_folder)) {
                mkdir($upload_folder, 0755, true);
            }
            // Delete logo from upload folder && database if remove button is pressed and do not upload logo
            if(!empty($company->logo) && $request->file_remove == 'true' && !$request->hasFile('logo')){
                $uploaded_logo_name = basename($company->logo);
                if(file_exists($upload_folder.$uploaded_logo_name)){
                    File::delete($upload_folder.$uploaded_logo_name);
                    $company->logo = null;
                }
            }
            if($request->hasFile('logo')) {
                // check if logo already exists in database
                if(!empty($company->logo)){
                    $uploaded_logo_name = basename($company->logo);
                    if(file_exists($upload_folder.$uploaded_logo_name)){
                        File::delete($upload_folder.$uploaded_logo_name);
                    }
                }
                $logo_name = $request->logo->getClientOriginalName();
                if(file_exists($upload_folder.$logo_name)){
                    $logo_name = str_replace('.' . $request->logo->getClientOriginalExtension(), '', $request->logo->getClientOriginalName()).mt_rand().'.' . $request->logo->getClientOriginalExtension();
                }
                $logo_name = str_replace([' ','_'], '-', strtolower($logo_name));
                if($request->logo->move($upload_folder, $logo_name)) {
                    $company->logo = $upload_folder.$logo_name;
                }
            }
            
            if(!$request->has('company_id')) {
                $msg = 'added';
                $company->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $company->updated_by = $request->user()->id;
            }
            if($company->save()) { 
                $company->slug = $company->id .'-'. str_slug($company->title);
                $company->save();

                // insert data to some some tables when company is created
                if(!$request->has('company_id')) {
                    // insert branch data
                    $branch = new Branch;
                    $branch->company_id = $company->id;
                    $branch->title = trim($request->branch_title);
                    $branch->description = trim($request->branch_description);
                    $branch->established_year = $request->has('branch_established_year') ? trim($request->branch_established_year) : null;
                    $branch->address = trim($request->branch_address);
                    $branch->city = trim($request->branch_city);
                    $branch->state = trim($request->branch_state);
                    $branch->zip = trim($request->branch_zip);
                    $branch->country = trim($request->branch_country);
                    $branch->created_by = $request->user()->id;
                    if($branch->save()) {

                        // insert designation data 
                        $designation = new Designation;
                        $designation->company_id = $company->id;
                        $designation->branch_id = $branch->id;
                        $designation->title = trim($request->designation_title);
                        
                        $designation->created_by = $request->user()->id;
                        $designation->save();

                        // insert department data
                        $department = new Department;
                        $department->company_id = $company->id;
                        $department->branch_id = $branch->id;
                        $department->title = trim($request->department_title);
                        
                        $department->created_by = $request->user()->id;

                        if($department->save() && !empty($designation->id)) { 

                            // insert employee data
                            $employee = new Employee;
                            $employee->company_id = $company->id;
                            $employee->branch_id = $branch->id;
                            $employee->department_id = $department->id;
                            $employee->designation_id = $designation->id;
                            $employee->full_name = trim($request->full_name);
                            $employee->gender = trim($request->gender);
                            $employee->phone = trim($request->phone);
                            $employee->created_by = $request->user()->id;
                            
                            if($employee->save()) {
                                // inert user data
                                $username = array_first(explode('@', trim($request->email)));
                                $user_exists = User::whereUsername($username)->first();
                                if($user_exists) {
                                    $username = $username . '_' . str_random(6);
                                }
                                $user = new User;
                                $user->employee_id = $employee->id;
                                $user->company_id = $company->id;
                                $user->branch_id = $branch->id;
                                $user->username = $username;
                                $user->email = trim($request->email);
                                $user->password = bcrypt($request->password);
                                $user->role = 'admin';
                                $user->active = 0;
                                if($user->save()) {
                                    
                                    //encode    
                                    $iat = Carbon::now()->timestamp;
                                    $exp = $iat+3600;  
                                    $token = [
                                        "resource" => $user->id,
                                        "iss" => env('APP_HOST'),
                                        "iat" => $iat,
                                        "exp" => $exp
                                    ];

                                    $jwt = \Firebase\JWT\JWT::encode($token, env('SSO_KEY'));

                                    $data = [
                                        'blade' => 'new_account',
                                        'body'  =>  [
                                            'name' => trim($request->full_name),
                                            'username'  => $username,
                                            'password'  => trim($request->password),
                                            'jwt'  => $jwt,
                                        ],
                                        'toUser'    =>  trim($request->email),
                                        'toUserName'    =>  $username,
                                        'subject'   =>  env('APP_NAME') . ' New Account Confirmation!',
                                    ];

                                    EmailSender::send($data);
                                }
                            }
                        }
                    }

                    // Set Default Option
                    setupDefaultSettings($company->id);
                }
                $message = toastMessage ( " Company information has been successfully $msg", 'success' );

            }else{
                $message = toastMessage ( " Company information has not been successfully $msg", 'error' );
            }
            // redirect
            session()->flash('toast', $message);
            
            return redirect('companies');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $countries = Country::pluck('name', 'country_code')->prepend('Select a Country', '')->all();

        return view('companies.edit', compact('company', 'countries'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Company::destroy($id)) {
            $message = toastMessage(' Company has been successfully removed', 'success');
        }else {
            $message = toastMessage(' Company has not been removed', 'error');
        }

        session()->flash('toast', $message);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(Company::destroy($request->hdnResource)){
            $message = toastMessage('Company has been successfully removed.','success');
        }else{
            $message = toastMessage('Company has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
     * Display a form of company and update company information
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function myCompany(Request $request)
    {
        $company = Company::findOrFail($request->user()->company_id);
        if($request->isMethod('POST')) {

            $rules = array(
                'title'         => 'required',
                'description'   => 'required',
                'established_year'  => 'required|date|date_format:Y-m-d',
                'country'     => 'required|max:10',
                'state'     => 'required|max:50',
                'city'     => 'required|max:50',
                'zip'     => 'required|max:50',
                'address'     => 'required',
            );
            if($request->hasFile('logo')) {
                $rules['logo'] = 'mimes:jpg,jpeg,png|max:1024';
            }

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                // store
                $company->title = trim($request->title);
                $company->slug = trim($request->title);
                $company->description = trim($request->description);
                $company->contact_person_name = trim($request->contact_person_name);
                $company->contact_person_phone = trim($request->contact_person_phone);
                $company->contact_person_email = trim($request->contact_person_email);
                $company->established_year = trim($request->established_year);
                $company->address = trim($request->address);
                $company->city = trim($request->city);
                $company->state = trim($request->state);
                $company->zip = trim($request->zip);
                $company->country = trim($request->country);
                /**
                * Upload logo
                */
                $upload_folder = 'uploads/company-logo/';
                // check whether folder already exist if not, create folder
                if(!file_exists($upload_folder)) {
                    mkdir($upload_folder, 0755, true);
                }
                // Delete logo from upload folder && database if remove button is pressed and do not upload logo
                if(!empty($company->logo) && $request->file_remove == 'true' && !$request->hasFile('logo')){
                    $uploaded_logo_name = basename($company->logo);
                    if(file_exists($upload_folder.$uploaded_logo_name)){
                        File::delete($upload_folder.$uploaded_logo_name);
                        $company->logo = null;
                    }
                }
                if($request->hasFile('logo')) {
                    // check if logo already exists in database
                    if(!empty($company->logo)){
                        $uploaded_logo_name = basename($company->logo);
                        if(file_exists($upload_folder.$uploaded_logo_name)){
                            File::delete($upload_folder.$uploaded_logo_name);
                        }
                    }
                    $logo_name = $request->logo->getClientOriginalName();
                    if(file_exists($upload_folder.$logo_name)){
                        $logo_name = str_replace('.' . $request->logo->getClientOriginalExtension(), '', $request->logo->getClientOriginalName()).mt_rand().'.' . $request->logo->getClientOriginalExtension();
                    }
                    $logo_name = str_replace([' ','_'], '-', strtolower($logo_name));
                    if($request->logo->move($upload_folder, $logo_name)) {
                        $company->logo = $upload_folder.$logo_name;
                    }
                }
                
                $company->updated_by = $request->user()->id;
                if($company->save()) { 
                    $company->slug = $company->id .'-'. str_slug($company->title);
                    $company->save();

                    $message = toastMessage ( " Company information has been successfully uapdated", 'success' );

                }else{
                    $message = toastMessage ( " Company information has not been updated", 'error' );
                }
                // redirect
                session()->flash('toast', $message);
                
                return redirect()->back();
            }
        }
        
        $countries = Country::pluck('name', 'country_code')->all();

        return view('companies.profile', compact('company', 'countries'));
    }
}
