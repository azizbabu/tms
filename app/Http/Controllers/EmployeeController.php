<?php

namespace App\Http\Controllers;
set_time_limit(0);
use Illuminate\Http\Request;

use App\Branch;
use App\Company;
use App\Department;
use App\Designation;
use App\Employee;
use App\EmployeeTask;
use App\Task;
use App\TodoList;
use App\User;
use Helpers\Classes\EmailSender;
use Carbon, File, Validator;

class EmployeeController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('department_admin', ['except' => ['getTaskManagement']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        if(!isSuperAdmin()){
            $query->whereCompanyId($request->user()->company_id);

            if(isDepartmentAdmin()) {
                $query->whereDepartmentId($request->user()->employee->company_id);
            }
        }

        $employees = $query->latest('id')->paginate(10);
        $employees->paginationSummery = getPaginationSummery($employees->total(), $employees->perPage(), $employees->currentPage());
        $companies = Company::getDropDownList();
        $branches = Branch::getDropDownList();
        $departments = Department::getDropDownList();

        return view('employees.index', compact('employees', 'companies', 'branches', 'departments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function employeeList(Request $request)
    {
        $query = Employee::query();

        if(!isSuperAdmin()) {
            $query->whereCompanyId($request->user()->company_id);

            if(isDepartmentAdmin()) {
                $query->whereDepartmentId($request->user()->employee->department_id);
            }
        }

        $employees = $query->where(function($query) use ($request) {
            if($request->has('company_id')) {
                $query->whereCompanyId($request->company_id);
            }
            if($request->has('branch_id')) {
                $query->whereBranchId($request->branch_id);
            }
            if($request->has('department_id')) {
                $query->whereDepartmentId($request->department_id);
            }
        })->latest('id')->get();
        // $employees->paginationSummery = getPaginationSummery($employees->total(), $employees->perPage(), $employees->currentPage());
        $companies = Company::getDropDownList();
        $branches = Branch::getDropDownList();
        $departments = Department::getDropDownList();

        return view('employees.index', compact('employees', 'companies', 'branches', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::getDropDownList();
        // $reporting_bosses = Employee::getReportingBossDropdownList();
        $tasks     = Task::getDropDownList(NULL, false);
        
        return view('employees.create', compact('companies', 'tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        if(isSuperAdmin()) {
            $rules['company_id'] = 'required|integer';
        }
        if(isSuperAdminOrAdmin()) {
            $rules = $rules + array(
                'branch_id'       => 'required|integer',
                'department_id'   => 'required|integer',
            );
        }
        $rules = $rules + array(
            'designation_id'  => 'required|integer',
            'full_name'     => 'required|max:255',
            'gender'     => 'required|max:20',
            'phone'     => 'required|max:50',
            
        );
        if($request->has('enable_web_access')) {
            $rules = $rules + [
                'email' => 'required|email|string|max:255|unique:users,email',
                'password' => 'required|string|min:6',
            ];

            if(isSuperAdminOrAdmin()) {
                $rules = $rules + [
                    'role'  => 'required|string',
                ];
            }
        }
        if($request->hasFile('photo')) {
            $rules['photo'] = 'mimes:jpg,jpeg,png|max:1024';
        }

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            // store
            $employee = !$request->has('employee_id') ? new Employee : Employee::findOrFail($request->employee_id);
            if(isSuperAdmin()) {
                $employee->company_id = trim($request->company_id);
            }else {
                $employee->company_id = $request->user()->company_id;
            }
            if(isSuperAdminOrAdmin()) {
                $employee->branch_id = trim($request->branch_id);
                $employee->department_id = trim($request->department_id);
            }else {
                $employee->branch_id = $request->user()->branch_id;
                $employee->department_id = $request->user()->employee->department_id;
            }
            
            $employee->designation_id = trim($request->designation_id);
            $employee->reporting_boss = $request->has('reporting_boss') ? trim($request->reporting_boss) : 0;
            $employee->code = trim($request->code);
            $employee->joining_date = $request->has('joining_date') ? trim($request->joining_date) : null;
            $employee->full_name = trim($request->full_name);
            $employee->fathers_name = trim($request->fathers_name);
            $employee->mothers_name = trim($request->mothers_name);
            $employee->dob = $request->has('dob') && $request->dob !== '0000-00-00' ? trim($request->dob) : null;
            $employee->religion = trim($request->religion);
            $employee->nationality = trim($request->nationality);
            $employee->gender = trim($request->gender);
            $employee->nid = trim($request->nid);
            $employee->phone = trim($request->phone);
            $employee->blood_group = trim($request->blood_group);
            $employee->passport_no = trim($request->passport_no);
            $employee->tin = trim($request->tin);
            $employee->present_address = trim($request->present_address);
            $employee->permanent_address = trim($request->permanent_address);
            $employee->blood_group = trim($request->blood_group);
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
            
            if(!$request->has('employee_id')) {
                $msg = 'added';
                $employee->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $employee->updated_by = $request->user()->id;
            }
            
            if($employee->save()) { 

                // Check whether enable web access button is checked. If checked then add new user
                if($request->has('enable_web_access')) {
                    // inert user data
                    $username = array_first(explode('@', trim($request->email)));
                    $user_exists = User::whereUsername($username)->first();
                    if($user_exists) {
                        $username = $username . '_' . str_random(6);
                    }
                    $user = new User;
                    $user->employee_id = $employee->id;
                    $user->company_id = $employee->company_id;
                    $user->branch_id = $employee->branch_id;
                    $user->username = $username;
                    $user->email = trim($request->email);
                    $user->password = bcrypt($request->password);
                    if(isSuperAdminOrAdmin()) {
                        $user->role = trim($request->role);
                    }else {
                        $user->role = 'employee';
                    }
                    
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
                $message = toastMessage ( " Employee information has been successfully $msg", 'success' );

            }else{
                $message = toastMessage ( " Employee information has not been successfully $msg", 'error' );
            }
            // redirect
            session()->flash('toast', $message);
            
            return redirect('employees/list');
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
        $employee = Employee::findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::getDropDownList();
        $reporting_bosses = Employee::getReportingBossDropdownList();
        $tasks = Task::getDropDownList(NULL, false);

        return view('employees.edit', compact('employee', 'reporting_bosses', 'companies', 'tasks'));
    }

    /**
    * Get employees based on company id
    *
    * @param int $id
    * @param int $employee_id
    * @return \Illuminate\Http\Response
    */
    public function getBranches($id, $employee_id=null)
    {
        $branches = Branch::whereCompanyId($id)->pluck('title', 'id')->all();

        $branch_options = '<option value="">Select a branch</option>';
        if($employee_id) {
            $employee = Employee::find($employee_id);
        }
        $selected = '';
        foreach($branches as $branch_id=>$title) {
            if(!empty($employee) && $employee->branch_id == $branch_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $branch_options .= '<option value="'.$branch_id.'"'.$selected.'>'.$title.'</option>';
        }

        $reporting_bosses = Employee::getReportingBossDropdownList(false, $id);

        $reporting_boss_options = '<option value="">Select a Employee</option>';

        $selected = '';
        foreach($reporting_bosses as $reporting_boss_id=>$reporting_boss_title) {
            if(!empty($employee) && $employee->reporting_boss == $reporting_boss_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $reporting_boss_options .= '<option value="'.$reporting_boss_id.'"'.$selected.'>'.$reporting_boss_title.'</option>';
        }

        return response()->json([
            'branch_options' => $branch_options,
            'reporting_boss_options' => $reporting_boss_options,
        ]);
    }


    /**
    * Get departments & designations based on branch id
    *
    * @param int $id
    * @param int $employee_id
    * @return \Illuminate\Http\Response
    */
    public function getDepartments($id, $employee_id=null)
    {
        if($employee_id) {
            $employee = Employee::find($employee_id);
        }

        $departments = Department::whereBranchId($id)->pluck('title', 'id')->all();

        $department_options = '<option value="">Select a department</option>';
        
        $selected = '';
        foreach($departments as $department_id=>$title) {
            if(!empty($employee) && $employee->department_id == $department_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $department_options .= '<option value="'.$department_id.'"'.$selected.'>'.$title.'</option>';
        }

        $designations = Designation::whereBranchId($id)->pluck('title', 'id')->all();

        $designation_options = '<option value="">Select a designation</option>';
        
        $selected = '';
        foreach($designations as $designation_id=>$title) {
            if(!empty($employee) && $employee->designation_id == $designation_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $designation_options .= '<option value="'.$designation_id.'"'.$selected.'>'.$title.'</option>';
        }

        return response()->json([ 
            'department_options' => $department_options, 
            'designation_options' => $designation_options, 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Employee::destroy($id)) {
            $message = toastMessage(' Employee has been successfully removed', 'success');
        }else {
            $message = toastMessage(' Employee has not been removed', 'error');
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
        $employees = Employee::whereIn('id', [$request->hdnResource])->get();
        $employee_ids = array_diff(Employee::getEmployeeIds($employees), [$request->user()->id]);

        if(Employee::destroy($employee_ids)){
            $message = toastMessage('Employee has been successfully removed.','success');
        }else{
            $message = toastMessage('Employee has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
     * Display a list of employees
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTaskManagement(Request $request)
    {
        $employees = Employee::whereIn('id',Employee::getEmployeeIds(Employee::tree()))->get();
        $todo_lists = TodoList::fetch($request)->get();
        $my_todo_lists = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->join('departments', 'tasks.department_id', '=', 'departments.id')
            ->join('employees', 'todo_lists.employee_id', '=', 'employees.id')
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->select('todo_lists.id','todo_lists.status', 'todo_lists.assigned_at', 'todo_lists.finished_at', 'todo_lists.deadline', 'tasks.title', 'tasks.frequency','tasks.job_type', 'employees.full_name', 'departments.title AS department_title')
            ->latest('todo_lists.id')->get();

        return view('employees.task_management', compact('employees', 'todo_lists', 'my_todo_lists'));
    }
}
