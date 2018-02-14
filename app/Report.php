<?php

namespace App;

use DB, Carbon;

class Report{

    private $from;
    private $to;
    private $branchId;
    private $percent;

    public function __construct($from="", $to=""){

        $this->from = empty($from) ? Carbon::now()->subDay(30) : Carbon::parse($from);
        $this->to = empty($to) ? Carbon::now() : Carbon::parse($to);
    }

    public function getEmployeePerformancePayloadByCompany($companyId, $limit=10, $orderBy="desc"){
        $employees = DB::table('employees as e')
        ->leftJoin('users as u', 'u.employee_id', '=', 'e.id')
        ->leftJoin('employee_tasks as et', 'et.employee_id', '=', 'e.id')
        ->leftJoin('tasks as t', 'et.task_id', '=', 't.id')
        ->leftJoin('task_roles as tr', 'et.task_role_id', '=', 'tr.id')
        ->leftJoin('todo_lists as tl', 'tl.employee_task_id', '=', 'et.id')
        ->select([
            'e.id',
            'u.username',
            'e.full_name',
            DB::raw("IFNULL(SUM(tr.role_weight),0) as task_point"),
            DB::raw("IFNULL(SUM(tl.earned_point),0) as earned_point")
        ])
        ->where('e.company_id', $companyId)
        ->groupBy('e.id')
        ->orderBy('earned_point',$orderBy)
        ->take($limit)
        ->get();

        $payloadArray = [];

        foreach($employees as $employee){

            //calculating parent of employee's point
            try{
                $percent = (100/$employee->task_point) * $employee->earned_point;
            }catch(\Exception $ex){
                $percent = 0;
            }

            $payloadArray[] = "{ username: '".$employee->username."', x: '".$employee->full_name."', y: 100, z: ".number_format((float)$percent, 2, '.', '')."}";
        }

        return implode(',', $payloadArray);
    }

    public function getBranchWisePerformancePayloadByCompany($companyId){

        $branches = DB::table('branches as b')
        ->leftJoin('departments as d', 'b.id', '=', 'd.branch_id')
        ->leftJoin('tasks as t', 'd.id', '=', 't.department_id')
        ->leftJoin('employee_tasks as et', 'et.task_id', '=', 't.id')
        ->leftJoin('task_roles as tr', 'et.task_role_id', '=', 'tr.id')
        ->leftJoin('todo_lists as tl', 'tl.employee_task_id', '=', 'et.id')
        ->select([
            'b.id',
            'b.title',
            DB::raw("IFNULL(SUM(tr.role_weight),0) as task_point"),
            DB::raw("IFNULL(SUM(tl.earned_point),0) as earned_point")
        ])
        ->where('b.company_id', $companyId)
        ->groupBy('b.id')
        ->orderBy('b.title','asc')
        ->get();

        $payloadArray = [];

        foreach($branches as $branch){

            //calculating parent of branch's point
            try{
                $percent = (100/$branch->task_point) * $branch->earned_point;
            }catch(\Exception $ex){
                $percent = 0;
            }

            $payloadArray[] = "{ id: ".$branch->id.", x: '".$branch->title."', y: 100, z: ".number_format((float)$percent, 2, '.', '')."}";
        }

        return implode(',', $payloadArray);
    }

    public function getDepartmentPerformancePayloadByBranch($branchId){

        $payload = "";

        $this->departments = DB::table('departments as d')
        ->leftJoin('tasks as t', 'd.id', '=', 't.department_id')
        ->leftJoin('employee_tasks as et', 'et.task_id', '=', 't.id')
        ->leftJoin('task_roles as tr', 'et.task_role_id', '=', 'tr.id')
        ->leftJoin('todo_lists as tl', 'tl.employee_task_id', '=', 'et.id')
        ->select([
            'd.id',
            'd.parent_id',
            'd.title',
            DB::raw("IFNULL(SUM(tr.role_weight),0) as task_point"),
            DB::raw("IFNULL(SUM(tl.earned_point),0) as earned_point")
        ])
        ->where('d.branch_id', $branchId)
        ->groupBy('d.id')
        ->orderBy('d.title','asc')
        ->get();

        $parents = $this->departments->where('parent_id', 0);

        $output = [];

        foreach($parents as $parent){

            $this->percent = 0;

            $task_point = $parent->task_point;
            $earned_point = $parent->earned_point;

            //calculating parent department's point
            try{
                $percent = (100/$task_point) * $earned_point;
            }catch(\Exception $ex){
                $percent = 0;
            }

            //adding child department's point with parent department's point
            $percent += $this->getCalculatePoint($parent);

            $output[$parent->id] = [
                'id' => $parent->id,
                'department' => $parent->title,
                'percent' => $percent
            ];
        }

        foreach($output as $out){
            $payload .= "{ id: ".$out['id'].",x: '".$out['department']."', y: 100, z: ".number_format((float)$out['percent'], 2, '.', '')."},";
        }

        return $payload;
    }

    public function getDepartmentPerformancePayloadByParent($department_ids){

        $payload = "";

        $this->departments = DB::table('departments as d')
        ->leftJoin('tasks as t', 'd.id', '=', 't.department_id')
        ->leftJoin('employee_tasks as et', 'et.task_id', '=', 't.id')
        ->leftJoin('task_roles as tr', 'et.task_role_id', '=', 'tr.id')
        ->leftJoin('todo_lists as tl', 'tl.employee_task_id', '=', 'et.id')
        ->select([
            'd.id',
            'd.parent_id',
            'd.title',
            DB::raw("IFNULL(SUM(tr.role_weight),0) as task_point"),
            DB::raw("IFNULL(SUM(tl.earned_point),0) as earned_point")
        ])
        ->whereIn('d.id', $department_ids)
        ->groupBy('d.id')
        ->orderBy('d.title','asc')
        ->get();
        
        $output = [];

        foreach($this->departments as $parent){

            $this->percent = 0;

            $task_point = $parent->task_point;
            $earned_point = $parent->earned_point;

            //calculating parent department's point
            try{
                $percent = (100/$task_point) * $earned_point;
            }catch(\Exception $ex){
                $percent = 0;
            }

            //adding child department's point with parent department's point
            $percent += $this->getCalculatePoint($parent);

            $output[$parent->id] = [
                'id' => $parent->id,
                'department' => $parent->title,
                'percent' => $percent
            ];
        }

        foreach($output as $out){
            $payload .= "{ id: ".$out['id'].",x: '".$out['department']."', y: 100, z: ".number_format((float)$out['percent'], 2, '.', '')."},";
        }

        return $payload;
    }

    private function getCalculatePoint($parent){

        $children = $this->departments->where('parent_id',(int)$parent->id);
        
        if($children->count() > 0){
            //calculating children department's point

            $this->task_point = $children->sum('task_point');
            $this->earned_point = $children->sum('earned_point');

            try{
                $this->percent += (100/$this->task_point) * $this->earned_point;
            }catch(\Exception $ex){
                $this->percent += 0;
            }

            foreach($children as $cd){
                $this->getCalculatePoint($cd);
            }
        }

        return $this->percent;
    }
}