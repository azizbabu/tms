<?php 

return [
	'app_name'	=> 'Task Auditor',
	'role'	=> [
		'super-admin'		=> 'Super Admin',
		'admin'				=> 'Admin',
		'department-admin'	=> 'Department Admin',
		'employee'			=> 'Employee',
	],
	'job_type'	=> [
		'need_basis'	=> 'Need Basis',
		'pre_defined'	=> 'Pre Defined',
	],
	'frequency'	=> [
		'once'			=> 'Once',
		'daily'			=> 'Daily',
		'weekly'		=> 'Weekly',
		'forthnightly'	=> 'Forthnightly',
		'monthly'		=> 'Monthly',
		'quarterly'		=> 'Quarterly',
		'half_yearly'	=> 'Half Yearly',
		'yearly'		=> 'Yearly',
	],
	'priority'	=> [
		'highest'	=> 'Highest',
		'high'		=> 'High',
		'normal'	=> 'Normal',
	],
	'task_status'	=> [
		'new'		=> 'New',
		'accepted'	=> 'Accepted',
		'completed'	=> 'Completed',
	],
	'days'	=> [
		0	=> 'Sunday',
		1	=> 'Monday',
		2	=> 'Tuesday',
		3	=> 'Wednesday',
		4	=> 'Thursday',
		5	=> 'Friday',
		6	=> 'Saturday',
	],
	'date_format'	=> [
		'M d, Y'	=> date('M d, Y'),
		'Y-m-d'		=> date('Y-m-d'),
		'm/d/Y'		=> date('m/d/Y'),
		'd/m/Y'		=> date('d/m/Y'),
	],
	'default_settings'	=> [
		'week_starts_on'=> 6,
		'date_format'	=> 'M d, Y',
		'timezone'		=> 'Asia/Dhaka',
		'day_off'		=> 5,
	],
	'financial_year'	=> [
		'jan-to-dec'	=> 'January to December',
		'july-to-june'	=> 'July to June'
	],
	'target_unit' => [
		'' => 'Select One',
		'taka' => 'Taka',
		'pieces' => 'Pieces'
	]
];