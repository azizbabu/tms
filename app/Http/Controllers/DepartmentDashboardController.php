<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\EmployeeTask;
use App\TodoList;
use Carbon, DB;

class DepartmentDashboardController extends Controller
{
    /**
     * Display dashboard of department
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    	$department = Department::find($id);

    	if(!$department) {
    		session('toast', toastMessage('Department not found!', 'error'));

    		return redirect('/');
    	}

    	$pointStatisticsPayload = $this->getPointStatisticsPayload($id);

    	$taskPointsEarnedPointsStaticsPayload = $this->getTaskPointsEarnedPoints($id);

    	return view('department_dashboard', compact('department', 'pointStatisticsPayload', 'taskPointsEarnedPointsStaticsPayload'));
    }

    private function getPointStatisticsPayload($id){
        /** statistics of last 30 days */

        $startDate = Carbon::now()->subDay(30);
        $endDate = Carbon::now();

        $points = DB::table('todo_lists as tl')->leftJoin('employee_tasks as et', function($join) {
            $join->on('tl.employee_id', '=', 'et.employee_id')->on('tl.task_id', '=', 'et.task_id');
        })->leftJoin('tasks as t', 'tl.task_id', '=', 't.id')
        ->leftJoin('departments as d', 't.department_id', '=', 'd.id')
        ->leftJoin('achievement_logs as al', 'tl.id', '=', 'al.todo_list_id')
        ->select(
            DB::raw('DATE_FORMAT(tl.assigned_at, "%Y-%m-%d") as assigned_at'),
            DB::raw('SUM(et.target) as target'),
            DB::raw('SUM(al.achievement) as achievement')
        )
        ->where('d.id', '=', $id)
        ->whereNotNull('et.target')
        ->whereRaw("(DATE_FORMAT(tl.assigned_at, '%Y-%m-%d') >= '".$startDate->format('Y-m-d')."' AND DATE_FORMAT(tl.assigned_at, '%Y-%m-%d') <='".$endDate->format('Y-m-d')."')")
        ->groupBy(DB::raw("DATE_FORMAT(tl.assigned_at, '%Y-%m-%d')"))
        ->get();

        $data = [];

        if($points->isNotEmpty()) {
            $i = 1;
            foreach($points as $point) {
                $data[] = "{ x: '".$point->assigned_at."', y: ".$point->target.", z: ".$point->achievement." }";
            }
        }

        $payload = implode(',', $data);

        return $payload;
    }
    

    private function getTaskPointsEarnedPoints($id)
    {
    	$startDate = Carbon::now()->subDay(30);
        $endDate = Carbon::now();

        $points = DB::table('todo_lists as tl')->rightJoin('tasks as t', 'tl.task_id', '=', 't.id')
        ->rightJoin('departments as d', 't.department_id', '=', 'd.id')
        ->rightJoin('task_roles as tr', 'tl.task_role_id', '=', 'tr.id')
        ->select(
            DB::raw("DATE_FORMAT(finished_at, '%Y-%m-%d') as `date`"),
            DB::raw("ROUND(SUM(tl.earned_point), 2) as earned_point"),
            DB::raw("ROUND(SUM(tr.role_weight), 2) as role_weight")
        )
        ->where('t.department_id', $id)
        ->whereRaw("(DATE_FORMAT(tl.finished_at, '%Y-%m-%d') >= '".$startDate->format('Y-m-d')."' AND DATE_FORMAT(tl.finished_at, '%Y-%m-%d') <='".$endDate->format('Y-m-d')."')")
        ->groupBy(DB::raw("DATE_FORMAT(finished_at, '%Y-%m-%d')"))
        ->get();

        $data = [];

        if($points->isNotEmpty()) {
        	foreach($points as $point) {
        		$taskRole = $point->role_weight ? $point->role_weight : 0;
        		$earnedPoint = $point->earned_point ? $point->earned_point : 0;

        		$data[] = "{ x: '".$point->date."', y: ".$taskRole.", z: ".$earnedPoint." }";
        	}
        }

        $payload = implode(',', $data);
        
        return $payload;
    }
}
