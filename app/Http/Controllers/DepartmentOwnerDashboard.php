<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use Carbon, DB;

class DepartmentOwnerDashboard extends Controller
{
    /**
     * Display different graphs associated to department
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$department = Department::find($request->user()->employee->department_id);
    	$department_ids[] = $department->id;
    	$child_departments = $department->children;
    	if($child_departments->IsNotEmpty()) {
    		$child_department_ids = Department::getDepartmentIds($child_departments);
    		$department_ids = array_merge($department_ids, $child_department_ids);

    		$immediate_child_department_ids = $child_departments->pluck('id')->all();

    		// $departmentWiseRoleWeightEarnedPoinPayload = $this->getDepartmentWiseRoleWeightEarnedPoints($request, $immediate_child_department_ids);
    		$report = new \App\Report(Carbon::now()->startOfYear(), Carbon::now()->endOfYear());

        	$departmentWiseEarnedPoint = $report->getDepartmentPerformancePayloadByParent($immediate_child_department_ids);

    	}

    	$monthWiseRoleWeightEarnedPoinPayload = $this->getMonthWiseRoleWeightEarnedPoints($request, $department_ids);

    	return view('department_owner_dashboard', compact('monthWiseRoleWeightEarnedPoinPayload', 'departmentWiseEarnedPoint'));
    }

    /**
     * Display monthbase payload of task role and 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function getMonthWiseRoleWeightEarnedPoints(Request $request, $department_ids)
    {
        $current_month = date('n');

        $points = DB::table('todo_lists as tl')->rightJoin('tasks as t', 'tl.task_id', '=', 't.id')
        ->rightJoin('departments as d', 't.department_id', '=', 'd.id')
        ->rightJoin('task_roles as tr', 'tl.task_role_id', '=', 'tr.id')
        ->select(
            DB::raw('MONTH(tl.assigned_at) as month'),
            DB::raw("ROUND(SUM(tl.earned_point), 2) as earned_point"),
            DB::raw("ROUND(SUM(tr.role_weight), 2) as role_weight")
        )
        ->whereIn('d.id', $department_ids)
        ->whereMonth('tl.assigned_at', '>=', 1)
        ->whereMonth('tl.assigned_at', '<=', $current_month)
        ->groupBy('month')
        ->get();

        $data = [];
        $active_data = [];
        if($points->isNotEmpty()) {
        	foreach($points as $point) {
        		$month = date('M', mktime(0, 0, 0, $point->month, 10));
        		$taskRole = $point->role_weight ? $point->role_weight : 0;
        		$earnedPoint = $point->earned_point ? $point->earned_point : 0;
        		if($taskRole) {
        			$taskRole = 100;
        			$earnedPoint = $earnedPoint/$taskRole * 100;
        		}

        		$active_data[$point->month] = "{ x: '".$month."', y: ".$taskRole.", z: ".$earnedPoint." }";
        	}
        }

        for ($i=1; $i <= $current_month; $i++) {
        	$month = date('M', mktime(0, 0, 0, $i, 10)); 
    		if(array_key_exists($i, $active_data)) {
    			$data[] = $active_data[$i];
    		}else {
    			$taskRole = 0;
    			$earnedPoint = 0;

    			$data[] = "{ x: '".$month."', y: ".$taskRole.", z: ".$earnedPoint." }";
    		}
    	}
    	
        $payload = implode(',', $data);
        
        return $payload;
    }

    /**
     * Display monthbase payload of task role and 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function getDepartmentWiseRoleWeightEarnedPoints(Request $request, $department_ids)
    {
    	$current_month = date('n');

        $points = DB::table('departments as d')
        ->leftJoin('tasks as t', 'd.id', '=', 't.department_id')
        ->leftJoin('employee_tasks as et', 'et.task_id', '=', 't.id')
        ->leftJoin('task_roles as tr', 'et.task_role_id', '=', 'tr.id')
        ->leftJoin('todo_lists as tl', 'tl.employee_task_id', '=', 'et.id')
        // ->select([
        //     'd.id',
        //     'd.parent_id',
        //     'd.title',
        //     DB::raw("IFNULL(SUM(tr.role_weight),0) as task_point"),
        //     DB::raw("IFNULL(SUM(tl.earned_point),0) as earned_point")
        // ])
        ->whereIn('d.id', $department_ids)
        // ->whereMonth('tl.assigned_at', '>=', 1)
        // ->whereMonth('tl.assigned_at', '<=', $current_month)
        ->groupBy('d.id')
        ->get();

        dd($points);

        $data = [];
        $active_data = [];
        if($points->isNotEmpty()) {
        	foreach($points as $point) {
        		$month = date('M', mktime(0, 0, 0, $point->month, 10));
        		$taskRole = $point->role_weight ? $point->role_weight : 0;
        		$earnedPoint = $point->earned_point ? $point->earned_point : 0;
        		if($taskRole) {
        			$taskRole = 100;
        			$earnedPoint = number_format($earnedPoint/$taskRole * 100, 2);
        		}

        		$active_data[$point->month] = "{ x: '".$month."', y: ".$taskRole.", z: ".$earnedPoint." }";
        	}
        }

        for ($i=1; $i <= $current_month; $i++) {
        	$month = date('M', mktime(0, 0, 0, $i, 10)); 
    		if(array_key_exists($i, $active_data)) {
    			$data[] = $active_data[$i];
    		}else {
    			$taskRole = 0;
    			$earnedPoint = 0;

    			$data[] = "{ x: '".$month."', y: ".$taskRole.", z: ".$earnedPoint." }";
    		}
    	}
    	
        $payload = implode(',', $data);
        
        return $payload;
    }
}
