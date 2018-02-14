<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

/**
* Company Factory
*/
$factory->define(App\Company::class, function(Faker\Generator $faker) {
	
	$super_admin = \App\User::whereRole('super-admin')->first(['id']);
	$gender_arr = ['male', 'female'];
	$gender = $gender_arr[array_rand($gender_arr)];
	$name = $faker->name($gender);
	$country_code = \App\Country::all()->random()->country_code;
	$this->country_code = $country_code;
	$company_title = $faker->unique()->company;

	return [
		'title'	=> $company_title,
		'slug'	=> str_slug($company_title),
		'description'	=> $faker->text,
		'contact_person_name'	=> $name,
		'established_year'	=> date('Y-m-d', strtotime('-'.mt_rand(20,40).' years')),
		'address'	=> $faker->address,
		'city'	=> $faker->city,
		'state'	=> $faker->state,
		'zip'	=> $faker->postcode,
		'country' => $this->country_code,
		'created_by'=> $super_admin ? $super_admin->id : 0,
	];
});

$factory->define(App\Branch::class, function(Faker\Generator $faker) {
	
	$gender_arr = ['male', 'female'];
	$gender = $gender_arr[array_rand($gender_arr)];
	$name = $faker->name($gender);

	return [
		'company_id'	=> !empty($this->company_id) ? $this->company_id : 0,
		'title'	=> ucfirst($faker->unique()->word),
		'description'	=> $faker->text,
		'contact_person_name'	=> $name,
		'established_year'	=> date('Y-m-d', strtotime('-'.mt_rand(20,40).' years')),
		'address'	=> $faker->address,
		'city'	=> $faker->city,
		'state'	=> $faker->state,
		'zip'	=> $faker->postcode,
		'country'	=> !empty($this->country_code) ? $this->country_code : 'BD',
		'created_by' => !empty($this->created_by) ? $this->created_by : 0,
	];
});

/**
* Department Factory
*/
$factory->define(App\Department::class, function(Faker\Generator $faker) {
	
	return [
		'company_id'	=> !empty($this->company_id) ? $this->company_id : 0,
		'branch_id'	=> !empty($this->branch_id) ? $this->branch_id : 0,
		'title'	=> ucfirst($faker->unique()->word),
		'description'	=> $faker->text,
		'priority'	=> mt_rand(1,100),
		'created_by'	=> !empty($this->created_by) ? $this->created_by : 0,
	];
});

/**
* Designation Factory
*/
$factory->define(App\Designation::class, function(Faker\Generator $faker) {
	
	return [
		'company_id'	=> !empty($this->company_id) ? $this->company_id : 0,
		'branch_id'	=> !empty($this->branch_id) ? $this->branch_id : 0,
		'title'	=> ucfirst($faker->unique()->word),
		'description'	=> $faker->text,
		'created_by'	=> !empty($this->created_by) ? $this->created_by : 0,
	];
});

/**
* Employee Factory
*/
$factory->define(App\Employee::class, function(Faker\Generator $faker) {
	$super_admin = \App\User::whereRole('super-admin')->first(['id']);
	// $reporting_bosses = \App\User::whereRole('admin')->get();
	// $reporting_boss = $reporting_bosses->isNotEmpty() ? $reporting_bosses->random()->id : 0;
	$gender_arr = ['male', 'female'];
	$gender = $gender_arr[array_rand($gender_arr)];
	$full_name = $faker->unique()->name($gender);
	

	return [
		'company_id'	=> $this->company_id,
		'branch_id'	=> !empty($this->branch_id) ? $this->branch_id : 0,
		'department_id'	=> factory(App\Department::class)->create()->id,
		'designation_id' => factory(App\Designation::class)->create()->id,
		'reporting_boss' => $super_admin && $super_admin->employee ? $super_admin->employee->id : 0,
		'code'	=> $faker->ean13,
		'joining_date'	=> date('Y-m-d', strtotime('-'.mt_rand(20,40).' days')),
		'full_name'	=> $full_name,
		'fathers_name'	=> $faker->name('male'),
		'mothers_name'	=> $faker->name('female'),
		'dob'	=> date('Y-m-d', strtotime('-'.mt_rand(20,40).' years')),
		'religion'	=> 'Islam',
		'nationality'	=> 'Bangladeshi',
		'gender'	=> $gender,
		'nid'	=> $faker->bankAccountNumber,
		'phone'	=> $faker->phoneNumber,
		'tin'	=> $faker->ean8,
		// 'created_by' => $super_admin ? $super_admin->id : 0,
		'created_by' => !empty($this->created_by) ? $this->created_by : 0,
	];
});

/**
* Employee Custom Factory
*/
$factory->defineAs(App\Employee::class, 'custom', function(Faker\Generator $faker) {
	$super_admin = \App\User::whereRole('super-admin')->first();
	// $reporting_bosses = \App\User::whereRole('admin')->get();
	// $reporting_boss = $reporting_bosses->isNotEmpty() ? $reporting_bosses->random()->id : ($super_admin ? $super_admin->id : 0);
	$gender_arr = ['male', 'female'];
	$gender = $gender_arr[array_rand($gender_arr)];
	$full_name = $faker->unique()->name($gender);
	

	return [
		'company_id'	=> 0,
		'branch_id'	=> 0,
		'department_id'	=> 0,
		'designation_id' => 0,
		'reporting_boss' => $super_admin && $super_admin->employee ? $super_admin->employee->id : 0,
		'code'	=> $faker->ean13,
		'joining_date'	=> date('Y-m-d', strtotime('-'.mt_rand(20,40).' days')),
		'full_name'	=> $full_name,
		'fathers_name'	=> $faker->name('male'),
		'mothers_name'	=> $faker->name('female'),
		'dob'	=> date('Y-m-d', strtotime('-'.mt_rand(20,40).' years')),
		'religion'	=> 'Islam',
		'nationality'	=> 'Bangladeshi',
		'gender'	=> $gender,
		'nid'	=> $faker->bankAccountNumber,
		'phone'	=> $faker->phoneNumber,
		'tin'	=> $faker->ean8,
		'created_by' => $super_admin ? $super_admin->id : 0,
	];
});

/**
* User Factory
*/
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $company = factory(App\Company::class)->create();
    $this->company_id = $company->id;
    $this->created_by = $company->created_by;
    $this->branch_id = factory(App\Branch::class)->create()->id;
    // Add default value into options tables  
    setupDefaultSettings($this->company_id);

    return [
    	'company_id' => $this->company_id,
    	'branch_id'	 => $this->branch_id,
    	'employee_id' => factory(App\Employee::class)->create()->id,
    	'username'	=>	$faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'role'	=> array_rand(config('constants.role')),
        'active'	=> 1,
        'remember_token' => str_random(10),
    ];
});


/**
* User Custom Factory
*/
$factory->defineAs(App\User::class, 'custom', function (Faker\Generator $faker) {
    static $password;

    return [
    	'company_id' => 0,
    	'branch_id'	 => 0,
    	'employee_id' => 0,
    	'username'	=>	$faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'role'	=> array_rand(config('constants.role')),
        'active'	=> 1,
        'remember_token' => str_random(10),
    ];
});


/**
* Task Factory
*/
$factory->define(App\Task::class, function (Faker\Generator $faker) {

    $admin_user = \App\User::whereRole('admin')->get()->random();
    $this->admin_id = $admin_user->id;
    $super_admin = \App\User::whereRole('super-admin')->first(['id']);
    $this->created_by = $super_admin->id;
    $task_title = $faker->unique()->jobTitle;

    return [
    	'company_id' => $this->employee->company_id,
    	'branch_id'	 => $this->employee->branch_id,
    	'department_id'	 => $this->employee->department_id,
    	'job_type' => array_rand(config('constants.job_type')),
    	'title'	=>	$task_title,
    	'slug'	=>  str_slug($task_title),
    	'description'	=>	$faker->text,
        'frequency' => array_rand(config('constants.frequency')),
        'status' => 'pending',
        'deadline'	=> date('Y-m-d', strtotime('+'.mt_rand(5,20).' days')),
        'priority'	=> array_rand(config('constants.priority')),
        'created_by' => $this->created_by,
    ];
});

/**
* Todo List Factory
*/
$factory->define(App\TodoList::class, function (Faker\Generator $faker) {

    return [
    	'task_id' => $this->task_id,
    	'employee_id'	 => $this->employee_id,
    	'assigned_by'	 => $this->created_by,
    	'assigned_at'	 => \Carbon::now(),
    ];
});

/**
* EmployeeTask Factory
*/
$factory->define(App\EmployeeTask::class, function (Faker\Generator $faker) {

    $this->employee = \App\User::whereRole(array_rand(array_except(config('constants.role'), ['super-admin'])))->get()->random()->employee;
    // $this->employee_id = $employee->id;
    $this->task_id = factory(App\Task::class)->create()->id;

    return [
    	'task_id' => $this->task_id,
    	'employee_id'	 => $this->employee->id,
    	'frequency_id'	=> \App\Frequency::whereNotIn('id', [1])->get()->random()->id,
    	'task_role_id' => \App\TaskRole::all()->random()->id,
    	'report_to'	=> $this->employee->id,
    	'deadline'	=> date('Y-m-d H:i:s', strtotime('+'.mt_rand(5,20).' days')),
    	'assigned_by'	 => $this->created_by,
    	'assigned_at'	 => \Carbon::now(),
    ];
});