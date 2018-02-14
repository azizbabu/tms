<?php 	

use App\Branch;
use App\Department;

function getDashboardPermission()
{
	$output = [];

	$departmentHtml = $branchHtml = "";

	//if no permission, we have nothing to do...
	if(empty(Auth::user()->permission)) return false;

	//storing permission data from auth object to local variable
	$permission = Auth::user()->permission;

	//configuration for menu builder
	$config = [
		'parent_ul_class' => "dropdown-menu",
		'parent_caret_icon' => "<span class='caret caret-right'></span>",
		'menu_item_class' => "test",
		'parent_menu_link' => false
	];

	//IF we have permitted branches
	if(!empty($permission->branch_ids)) {

		//taking permitted branch from db
		$branches = Branch::whereIn('id', explode(',', $permission->branch_ids))->get(['id', 'title']);

		//setup branch dashboard link
		$config['menu_url'] = 'branch-dashboard/[ID]';

		//init menu builder with permitted branchs and configuration
		$menuBuilder = new \Helpers\Classes\MenuBuilder($branches, $config);
		
		//getting menu as ul li html format
		$branchHtml = $menuBuilder->getMenuHtml();

		//storing branch menu html in local array variable
		$output['branche_menu'] = $branchHtml;
	}

	//IF we have permitted departments
	if(!empty($permission->department_ids)) {

		//taking permitted departments from db
		$departments = Department::whereIn('id', explode(',', $permission->department_ids))->get(['id', 'parent_id as parent', 'title']);

		//setup department dashboard link
		$config['menu_url'] = 'department-dashboard/[ID]';

		//init menu builder with permitted departments and configuration
		$menuBuilder = new \Helpers\Classes\MenuBuilder($departments, $config);
		
		//getting menu as ul li html format
		$departmentHtml = $menuBuilder->getMenuHtml();

		//storing departments menu html in local array variable
		$output['department_menu'] = $departmentHtml;
	}

	//finally check we have proper output, and IF we have return output otherwise return FALSE
	return count($output) > 0 ? $output : false;
}
