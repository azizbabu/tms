<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\Employee;
use App\EmployeeTask;
use App\TodoList;

use Carbon, DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $pointStatisticsPayload = $this->getPointStatisticsPayload();

        $deadlineStatisticsPayload = $this->getDeadlineStatisticsPayload();

        // Get tasks of current month
        $todo_lists_current_month = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->leftJoin('task_roles', 'todo_lists.task_role_id', '=', 'task_roles.id')
            ->select(
                'tasks.title',
                DB::raw('SUM(todo_lists.earned_point) as earned_point'),
                DB::raw('SUM(task_roles.role_weight) as role_weight')
            )
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->where('todo_lists.assigned_at', '>=', Carbon::now()->startOfMonth())
            ->groupBy('tasks.id')
            ->latest('todo_lists.id')->get();

        /**
         * Get month graph
         */
        $chart_current_month_data = '';
        foreach($todo_lists_current_month as $todo_list) {

            $title = str_replace(["'"], ["&#39;"], $todo_list->title);
            // convert to persentage
            $roleWeight = $todo_list->role_weight ? 100 : 0;
            $earnedPoint = $todo_list->role_weight && $todo_list->earned_point ? number_format($todo_list->earned_point/$todo_list->role_weight *100, 2) : 0;
            
            $chart_current_month_data .= "{ x: '".$title."', y: ".$roleWeight.", z: ".$earnedPoint."},";
        }

        /**
         * Get year graph
         */
        $financial_year = getOption('financial_year');
        $current_month = date('n');
        $chart_year_data = '';
        if($financial_year == 'jan-to-dec') {
            // year graph for january to december
            $todo_lists_year = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
                ->leftJoin('task_roles', 'todo_lists.task_role_id', '=', 'task_roles.id')
                ->select(DB::raw('month(todo_lists.assigned_at) month'), DB::raw('SUM(task_roles.role_weight) AS total_role_weight'), DB::raw('SUM(todo_lists.earned_point) AS total_earned_point'))
                ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
                ->whereMonth('todo_lists.assigned_at', '<=', $current_month)
                ->groupBy('month')
                ->latest('todo_lists.id')->get()->toArray();
            $todo_lists_month_arr = [];
            foreach($todo_lists_year as $key=>$value) {
                $todo_lists_month_arr[$value['month']] = $value;
            }
            for ($i=1; $i <= $current_month; $i++) { 
                
                $total_role_weight = array_key_exists($i, $todo_lists_month_arr) ? ($todo_lists_month_arr[$i]['total_role_weight'] ? $todo_lists_month_arr[$i]['total_role_weight'] : 0) : 0;

                $total_earned_point = $total_role_weight && array_key_exists($i, $todo_lists_month_arr) ? number_format($todo_lists_month_arr[$i]['total_earned_point']/$total_role_weight * 100, 2) : 0;
                $total_role_weight = $total_role_weight ? 100 : 0;

                $chart_year_data .= "{ x: '".date('M', mktime(0, 0, 0, $i, 10))."', y: ".$total_role_weight.", z: ".$total_earned_point."},";
            }
        }else {
            // year graph for july to june
            if($current_month < 7) {
                // get data from july to december of last year
                $todo_lists_last_year = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
                    ->leftJoin('task_roles', 'todo_lists.task_role_id', '=', 'task_roles.id')
                    ->select(DB::raw('month(todo_lists.assigned_at) month'), DB::raw('SUM(task_roles.role_weight) AS total_role_weight'), DB::raw('SUM(todo_lists.earned_point) AS total_earned_point'))
                    ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
                    ->whereMonth('todo_lists.assigned_at', '>=', 7)
                    ->whereMonth('todo_lists.assigned_at', '<=', 12)
                    ->whereYear('todo_lists.assigned_at', '<=', date("Y",strtotime("-1 year")))
                    ->groupBy('month')
                    ->latest('todo_lists.id')->get()->toArray();
                $todo_lists_month_arr = [];
                foreach($todo_lists_last_year as $key=>$value) {
                    $todo_lists_month_arr[$value['month']] = $value;
                }
                for ($i=7; $i <= 12; $i++) { 

                    $total_role_weight = array_key_exists($i, $todo_lists_month_arr) ? ($todo_lists_month_arr[$i]['total_role_weight'] ? $todo_lists_month_arr[$i]['total_role_weight'] : 0) : 0;

                    $total_earned_point = $total_role_weight && array_key_exists($i, $todo_lists_month_arr) ? number_format($todo_lists_month_arr[$i]['total_earned_point']/$total_role_weight * 100, 2) : 0;
                    $total_role_weight = $total_role_weight ? 100 : 0;

                    $chart_year_data .= "{ x: '".date('M', mktime(0, 0, 0, $i, 10))."', y: ".$total_role_weight.", z: ".$total_earned_point."},";
                }
                // get data from January to current month of current year
                $todo_lists_current_year = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
                    ->leftJoin('task_roles', 'todo_lists.task_role_id', '=', 'task_roles.id')
                    ->select(DB::raw('month(todo_lists.assigned_at) month'), DB::raw('SUM(task_roles.role_weight) AS total_role_weight'), DB::raw('SUM(todo_lists.earned_point) AS total_earned_point'))
                    ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
                    ->whereMonth('todo_lists.assigned_at', '>=', 1)
                    ->whereMonth('todo_lists.assigned_at', '<=', $current_month)
                    ->groupBy('month')
                    ->latest('todo_lists.id')->get()->toArray();
                foreach($todo_lists_current_year as $key=>$value) {
                    $todo_lists_month_arr[$value['month']] = $value;
                }
                for ($i=1; $i <= $current_month; $i++) { 
                    
                    $total_role_weight = array_key_exists($i, $todo_lists_month_arr) ? ($todo_lists_month_arr[$i]['total_role_weight'] ? $todo_lists_month_arr[$i]['total_role_weight'] : 0) : 0;

                    $total_earned_point = $total_role_weight && array_key_exists($i, $todo_lists_month_arr) ? number_format($todo_lists_month_arr[$i]['total_earned_point']/$total_role_weight * 100, 2) : 0;
                    $total_role_weight = $total_role_weight ? 100 : 0;
                    
                    $chart_year_data .= "{ x: '".date('M', mktime(0, 0, 0, $i, 10))."', y: ".$total_role_weight.", z: ".$total_earned_point."},";
                }
            }else {
                // get data from july to current month of this year
                $todo_lists_year = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
                    ->leftJoin('task_roles', 'todo_lists.task_role_id', '=', 'task_roles.id')
                    ->select(DB::raw('month(todo_lists.assigned_at) month'), DB::raw('SUM(task_roles.role_weight) AS total_role_weight'), DB::raw('SUM(todo_lists.earned_point) AS total_earned_point'))
                    ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
                    ->whereMonth('todo_lists.assigned_at', '>=', 7)
                    ->whereMonth('todo_lists.assigned_at', '<=', $current_month)
                    ->groupBy('month')
                    ->latest('todo_lists.id')->get()->toArray();
                $todo_lists_month_arr = [];
                foreach($todo_lists_year as $key=>$value) {
                    $todo_lists_month_arr[$value['month']] = $value;
                }
                for ($i=7; $i <= $current_month; $i++) { 
                    
                    $total_role_weight = array_key_exists($i, $todo_lists_month_arr) ? ($todo_lists_month_arr[$i]['total_role_weight'] ? $todo_lists_month_arr[$i]['total_role_weight'] : 0) : 0;

                    $total_earned_point = $total_role_weight && array_key_exists($i, $todo_lists_month_arr) ? number_format($todo_lists_month_arr[$i]['total_earned_point']/$total_role_weight * 100, 2) : 0;
                    $total_role_weight = $total_role_weight ? 100 : 0;
                    
                    $chart_year_data .= "{ x: '".date('M', mktime(0, 0, 0, $i, 10))."', y: ".$total_role_weight.", z: ".$total_earned_point."},";
                }
            }
        }

        $chart_current_month_data = substr($chart_current_month_data, 0, -1);

        // Get tasks of current month
        $total_earned_point_current_month = 0;
        $total_earned_point_within_deadline = 0;
        $total_earned_point_deadline_pass = 0;
        if($todo_lists_current_month) {
            foreach($todo_lists_current_month as $todo_list) {
                $total_earned_point_current_month += $todo_list->earned_point;
                if($todo_list->deadline && $todo_list->finished_at) {
                    $deadline = Carbon::parse($todo_list->deadline);
                    $finished_at = Carbon::parse($todo_list->finished_at);
                    // check task completed within deadline
                    if($finished_at->diffInDays($deadline, false) >= 0) {
                        $total_earned_point_within_deadline += $todo_list->earned_point;
                    }

                    // check task completed passing deadline
                    if($deadline->diffInDays($finished_at, false) > 0) {
                        $total_earned_point_deadline_pass += $todo_list->earned_point;
                    }
                }
            }
        }

        $earned_point_within_deadline = 0;
        $earned_point_passing_deadline = 0;
        if($total_earned_point_current_month) {
            $earned_point_within_deadline = number_format($total_earned_point_within_deadline*100/$total_earned_point_current_month,2);
            $earned_point_passing_deadline = number_format($total_earned_point_deadline_pass*100/$total_earned_point_current_month,2);
        } 

        $chart_task_completed_data = "{ x:'Within Deadline ', y: ".$earned_point_within_deadline." },{ x:'Deadline Miss ', y: ".$earned_point_passing_deadline." }";

        if($request->user()->employee && $request->user()->employee->servants->isNotEmpty()) {
            $employee_ids = array_except(Employee::getEmployeeIds(Employee::tree()), [array_search($request->user()->employee->id, Employee::getEmployeeIds(Employee::tree()))]);
            $employees = Employee::whereIn('id',$employee_ids)->get();
            $todo_lists = TodoList::fetch($request)->get();
        }
        
        $my_todo_lists = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->join('departments', 'tasks.department_id', '=', 'departments.id')
            ->join('employees', 'todo_lists.employee_id', '=', 'employees.id')
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->select('todo_lists.id','todo_lists.status', 'todo_lists.assigned_at', 'todo_lists.finished_at', 'todo_lists.deadline', 'tasks.title', 'tasks.frequency','tasks.job_type', 'employees.full_name', 'departments.title AS department_title')
            ->latest('todo_lists.id')->get();

        return view('home', compact('pointStatisticsPayload','deadlineStatisticsPayload','chart_current_month_data', 'chart_year_data', 'chart_task_completed_data', 'earned_point_within_deadline', 'earned_point_passing_deadline'));
    }

    private function getPointStatisticsPayload(){
        /** statistics of last 15 days */

        $startDate = Carbon::now()->subDay(15);
        $endDate = Carbon::now();

        $points = TodoList::select(
            DB::raw("DATE_FORMAT(finished_at, '%Y-%m-%d') as `date`"),
            DB::raw("ROUND(SUM(earned_point), 2) as earned_point")
        )
        ->whereNotNull('finished_at')
        ->whereEmployeeId(\Auth::user()->employee_id)
        ->whereRaw("(DATE_FORMAT(finished_at, '%Y-%m-%d') BETWEEN '".$startDate->format('Y-m-d')."' AND '".$endDate->format('Y-m-d')."')")
        ->groupBy(DB::raw("DATE_FORMAT(finished_at, '%Y-%m-%d')"))
        ->get();

        $data = [];
        while($startDate->lte($endDate)){

            $point = $points->where('date',$startDate->format('Y-m-d'))->first();

            $earnedPoint = !empty($point->earned_point) ? $point->earned_point : 0;

            $data[] = "{ y: '".$startDate->format('Y-m-d')."', a: ".$earnedPoint." }";

            $startDate = $startDate->addDay();
        }

        $payload = implode(',', $data);

        return $payload;
    }

    private function getDeadlineStatisticsPayload(){
        /** statistics of last 30 days */
        $startDate = Carbon::now()->subDay(30);
        $endDate = Carbon::now();

        $todoList = TodoList::select([
            'finished_at','deadline','extended_dateline_1','extended_dateline_2'
        ])
        ->whereNotNull('finished_at')
        ->whereEmployeeId(\Auth::user()->employee_id)
        ->whereRaw("(DATE_FORMAT(finished_at, '%Y-%m-%d') BETWEEN '".$startDate->format('Y-m-d')."' AND '".$endDate->format('Y-m-d')."')")
        ->get();

        $withInDateline = $withInExtDateline1 = $withInExtDateline2 = $failed = 0;

        if($todoList->count() > 0){
            foreach($todoList as $tl){

                $finished_at = Carbon::parse($tl->finished_at);
                $deadline = Carbon::parse($tl->deadline);
                $extended_dateline_1 = Carbon::parse($tl->extended_dateline_1);
                $extended_dateline_2 = Carbon::parse($tl->extended_dateline_2);

                if($finished_at->lte($deadline)){
                    $withInDateline ++;
                }elseif($finished_at->lte($extended_dateline_1)){
                    $withInExtDateline1++;
                }elseif($finished_at->lte($extended_dateline_2)){
                    $withInExtDateline2++;
                }else{
                    $failed++;
                }
            }
        }

        return "{label: 'Done Within Deadline', value: $withInDateline},{label: 'Done Within Ex. Deadline1', value: $withInExtDateline1},{label: 'Done Within Ex. Deadline2', value: $withInExtDateline2},{label: 'Failed', value: $failed}";
    }
}
