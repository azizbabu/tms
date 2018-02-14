<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use Carbon, DB;

class BranchDashboardController extends Controller
{
    /**
     * Display dashboard of branch
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    	$branch = Branch::find($id);

    	if(!$branch) {
    		session('toast', toastMessage('Branch not found!', 'error'));

    		return redirect('/');
    	}

    	$pointStatisticsPayload = $this->getPointStatisticsPayload($id);

    	$taskPointsEarnedPointsStaticsPayload = $this->getTaskPointsEarnedPoints($id);

        $report = new \App\Report('2017-01-01', '2017-12-31');

        $departmentWiseEarnedPoint = $report->getDepartmentPerformancePayloadByBranch($id);

    	return view('branch_dashboard', compact('branch', 'pointStatisticsPayload', 'taskPointsEarnedPointsStaticsPayload','departmentWiseEarnedPoint'));
    }

    private function getPointStatisticsPayload($id){
        // /** statistics of last 30 days */

        // $startDate = Carbon::now()->subDay(30);
        // $endDate = Carbon::now();

        // $points = DB::table('todo_lists as tl')->rightJoin('tasks as t', 'tl.task_id', '=', 't.id')
        // ->rightJoin('departments as d', 't.department_id', '=', 'd.id')
        // ->select(
        //     'd.title',
        //     DB::raw("ROUND(SUM(tl.earned_point), 2) as earned_point")
        // )
        // ->where('t.branch_id', $id)
        // ->groupBy('t.department_id')
        // ->get();

        // $data = [];

        // if($points->isNotEmpty()) {
        // 	foreach($points as $point) {
        // 		$earnedPoint = $point->earned_point ? $point->earned_point : 0;
        // 		$data[] = "{ x: '".$point->title."', y: ".$earnedPoint." }";
        // 	}
        // }

        // $payload = implode(',', $data);
        
        // return $payload;

        /** statistics of last 30 days */

        $startDate = Carbon::now()->subDay(30);
        $endDate = Carbon::now();

        $points = DB::table('todo_lists as tl')->leftJoin('employee_tasks as et', function($join) {
            $join->on('tl.employee_id', '=', 'et.employee_id')->on('tl.task_id', '=', 'et.task_id');
        })->leftJoin('tasks as t', 'tl.task_id', '=', 't.id')
        ->leftJoin('departments as d', 't.department_id', '=', 'd.id')
        ->leftJoin('achievement_logs as al', 'tl.id', '=', 'al.todo_list_id')
        ->select(
            'd.title',
            DB::raw('SUM(et.target) as target'),
            DB::raw('SUM(al.achievement) as achievement')
        )
        ->where('t.branch_id', '=', $id)
        ->whereNotNull('et.target')
        ->whereRaw("(DATE_FORMAT(tl.assigned_at, '%Y-%m-%d') >= '".$startDate->format('Y-m-d')."' AND DATE_FORMAT(tl.assigned_at, '%Y-%m-%d') <='".$endDate->format('Y-m-d')."')")
        ->groupBy('d.id')
        ->get();

        $data = [];

        if($points->isNotEmpty()) {
            foreach($points as $point) {
                $data[] = "{ x: '".$point->title."', y: ".$point->target.", z: ".$point->achievement." }";
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
            'd.title',
            DB::raw("ROUND(SUM(tl.earned_point), 2) as earned_point"),
            DB::raw("ROUND(SUM(tr.role_weight), 2) as role_weight")
        )
        ->where('t.branch_id', $id)
        ->whereRaw("(DATE_FORMAT(tl.assigned_at, '%Y-%m-%d') >= '".$startDate->format('Y-m-d')."' AND DATE_FORMAT(tl.assigned_at, '%Y-%m-%d') <='".$endDate->format('Y-m-d')."')")
        ->groupBy('t.department_id')
        ->get();

        $data = [];

        if($points->isNotEmpty()) {
        	foreach($points as $point) {
        		$taskRole = $point->role_weight ? $point->role_weight : 0;
        		$earnedPoint = $point->earned_point ? $point->earned_point : 0;

        		$data[] = "{ x: '".$point->title."', y: ".$taskRole.", z: ".$earnedPoint." }";
        	}
        }

        $payload = implode(',', $data);
        
        return $payload;
    }
}
