<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Department;
use App\Employee;

class OwnerDashboardController extends Controller
{
    public function index(Request $request){

    	if(isSuperAdmin() || isAdmin()){

            $branches = Branch::getDropdownList();
            $departments = Department::getDropdownList();
            $employees = Employee::getReportingBossDropdownList(true, null, 'username');

           	$report = new \App\Report('2017-01-01', '2017-12-31');

           	$branchWisePerformance = $report->getBranchWisePerformancePayloadByCompany($request->user()->company_id);

            $top10BestEmployeePerformance = $report->getEmployeePerformancePayloadByCompany($request->user()->company_id);

            $top10WorstEmployeePerformance = $report->getEmployeePerformancePayloadByCompany($request->user()->company_id, 10, 'asc');

            return view('owner-dashboard', compact('branches', 'departments', 'employees', 'branchWisePerformance','top10BestEmployeePerformance','top10WorstEmployeePerformance'));
        }else{
            return view('errors.403');
        }
    }
}
