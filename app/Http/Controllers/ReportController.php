<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\Task;
use App\TodoList;

use DB, PDF;

class ReportController extends Controller
{
	/**
	 * Display todo report
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function todoReport(Request $request, $action='')
    {
    	if(count($request->all())) {
    		$todo_lists = TodoList::fetch($request)->get();
    	}
    	
    	$employees = Employee::getReportDropdownList(null, true);

    	if($request->has('date_range')) {
            $date_range  = explode(' - ',$request->date_range);
            $from_date = \Carbon::parse($date_range[0])->format('Y-m-d');
            $to_date = \Carbon::parse($date_range[1])->format('Y-m-d');
        }

        if($action == 'print') {
        	return view('prints.todo', compact('todo_lists', 'from_date', 'to_date'));
        }elseif($action == 'pdf') {
        	return PDF::loadView('pdf.todo', compact('todo_lists', 'from_date', 'to_date'))->setPaper('a4', 'landscape')->setWarnings(false)->stream('todo-report.pdf');
        }

    	return view('reports.todo', compact('todo_lists', 'employees', 'from_date', 'to_date'));
    }

    /**
     * Display target vs achievement report of employee
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTargetAchievementReport(Request $request, $action='')
    {
        if(count($request->all())) {
            $employee_tasks = DB::table('tasks as t')
                ->leftJoin('employee_tasks as et', 't.id', '=', 'et.task_id')
                ->leftJoin('todo_lists as tl', 'et.id', '=', 'tl.employee_task_id')
                
                ->leftJoin('achievement_logs as al', 'tl.id', '=', 'al.todo_list_id')
                ->select('t.title', 
                    't.job_type', 
                    'et.target', 
                    DB::raw('IFNULL(SUM(al.achievement), 0) as achievement'))
                ->where(function($query) use($request) {
                    if($request->has('employee_id')) {
                        $query->where('et.employee_id', $request->employee_id);
                    }
                    if($request->has('date_range')) {

                        $date_range  = explode(' - ',$request->date_range);
                        $from_date = \Carbon::parse($date_range[0])->format('Y-m-d');
                        $to_date = \Carbon::parse($date_range[1])->format('Y-m-d');
                        $query->whereRaw('DATE_FORMAT(tl.assigned_at, "%Y-%m-%d") >= "'.$from_date.'" AND DATE_FORMAT(tl.assigned_at, "%Y-%m-%d") <="'.$to_date.'"');
                    }
                })
                ->groupBy('t.id')
                ->orderBy('t.title')
                ->get();
        }

        $employees = Employee::getReportDropdownList(null, true);

        if($request->has('date_range')) {
            $date_range  = explode(' - ',$request->date_range);
            $from_date = \Carbon::parse($date_range[0])->format('Y-m-d');
            $to_date = \Carbon::parse($date_range[1])->format('Y-m-d');
        }

        if($action == 'print') {
            return view('prints.target_achievement', compact('employee_tasks', 'from_date', 'to_date'));
        }elseif($action == 'pdf') {
            return PDF::loadView('pdf.target_achievement', compact('employee_tasks', 'from_date', 'to_date'))->setPaper('a4', 'landscape')->setWarnings(false)->stream('target-achievement-report.pdf');
        }

        return view('reports.target_achievement', compact('employee_tasks', 'employees', 'from_date', 'to_date'));
    }
}
