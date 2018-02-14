<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Company;
use App\Department;
use App\TaskRole;
use Carbon, Validator;

class TaskRoleController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('department_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = TaskRole::query();

        if(!isSuperAdmin()) {
            $query->whereCompanyId($request->user()->company_id);
        }
        
        $task_roles = $query->latest('id')->paginate(10);
        $task_roles->paginationSummery = getPaginationSummery($task_roles->total(), $task_roles->perPage(), $task_roles->currentPage());
        $companies = Company::getDropDownList();

        return view('task_roles.index', compact('task_roles', 'companies'));
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
            $rules = $rules + [
                'company_id' => 'required|integer',
            ];
        }
        if(isSuperAdminOrAdmin()) {
            $rules = $rules + array(
                'branch_id'       => 'required|integer',
                'department_id'   => 'required|integer',
            );
        }
        $rules = $rules + [
            'role_name' => 'required|string',
            'role_weight' => 'required|integer|min:1|max:'.(getOption('task_weight_scale', $request->user()->company_id) ? getOption('task_weight_scale', $request->user()->company_id) : 100),
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            $task_role = !$request->has('task_role_id') ? new TaskRole : TaskRole::findOrFail($request->task_role_id);
            if(isSuperAdmin()) {
                $task_role->company_id = $request->company_id;
            }else {
                $task_role->company_id = $request->user()->company_id;
            }
            if(isSuperAdminOrAdmin()) {
                $task_role->branch_id = trim($request->branch_id);
                $task_role->department_id = trim($request->department_id);
            }else {
                $task_role->branch_id = $request->user()->branch_id;
                $task_role->department_id = $request->user()->employee->department_id;
            }
            $task_role->role_name = $request->role_name;
            $task_role->role_weight = $request->role_weight;
            
            if(!$request->has('task_role_id')) {
                $msg = 'added';
                $task_role->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $task_role->updated_by = $request->user()->id;
            }
            if($task_role->save()) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => 'Task role has been successfully '.$msg]);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Task role has not been successfully '.$msg]);
            }
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
        $task_role = TaskRole::findOrFail($id);

        return $task_role->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(TaskRole::destroy($request->hdnResource)){
            $message = toastMessage('Task role has been successfully removed.','success');
        }else{
            $message = toastMessage('Task role has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
    * Get branches based on company id
    *
    * @param int $id
    * @param int $task_role_id
    * @return \Illuminate\Http\Response
    */
    public function getBranches($id, $task_role_id=null)
    {
        $branches = Branch::whereCompanyId($id)->pluck('title', 'id')->all();

        $branch_options = '<option value="">Select a branch</option>';
        if($task_role_id) {
            $task_role = TaskRole::find($task_role_id);
        }
        $selected = '';
        foreach($branches as $branch_id=>$title) {
            if(!empty($task_role) && $task_role->branch_id == $branch_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $branch_options .= '<option value="'.$branch_id.'"'.$selected.'>'.$title.'</option>';
        }
        
        return response()->json([
            'branch_options' => $branch_options,
        ]);
    }


    /**
    * Get departments based on branch id
    *
    * @param int $id
    * @param int $task_role_id
    * @return \Illuminate\Http\Response
    */
    public function getDepartments($id, $task_role_id=null)
    {
        if($task_role_id) {
            $task_role = TaskRole::find($task_role_id);
        }

        $departments = Department::whereBranchId($id)->pluck('title', 'id')->all();

        $department_options = '<option value="">Select a department</option>';
        
        $selected = '';
        foreach($departments as $department_id=>$title) {
            if(!empty($task_role) && $task_role->department_id == $department_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $department_options .= '<option value="'.$department_id.'"'.$selected.'>'.$title.'</option>';
        }

        return response()->json([ 
            'department_options' => $department_options
        ]);
    }
}
