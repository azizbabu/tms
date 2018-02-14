<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitDataSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initDataSetup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate some init data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Create Super Admin
        $employee = new \App\Employee;
        $employee->code = str_random(20);
        $employee->joining_date = date('Y-m-d', strtotime('-3 months'));
        $employee->full_name = 'Mr. Admin';
        $employee->fathers_name = 'Md. Abdul Malek';
        $employee->mothers_name = 'Mrs. Rokeya Shakawat';
        $employee->dob = date('Y-m-d', strtotime('-25 years'));
        $employee->religion = 'Islam';
        $employee->nationality = 'Bangladeshi';
        $employee->gender = 'male';
        $employee->nid = '12345678901234';
        $employee->phone = '01917656543';
        if($employee->save()) {
            $user = new \App\User();
            $user->employee_id = $employee->id;
            $user->username = 'super-admin';
            $user->email = 'super-admin@example.com';
            $user->last_login = \Carbon::now();
            // $user->last_ip = empty($_SERVER['REMOTE_ADDR']) ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
            $user->role = 'super-admin';
            $user->password = bcrypt('password');
            $user->save();

            $super_admin_id = $user->id;

            // Create Admin
            $admin = factory(\App\User::class)->create([
                'username'  => 'admin',
                'email'  => 'admin@example.com',
                'role'  => 'admin',
            ]);

            $admin->employee->reporting_boss = $employee->id;
            $admin->employee->save();

            // Create Employee 
            $employee = factory(\App\Employee::class, 'custom')->create([
                'company_id'=> $admin->company_id,
                'branch_id' => $admin->branch_id,
                'department_id' => $admin->employee->department_id,
                'designation_id' => $admin->employee->designation_id,
            ]);

            $user = factory(\App\User::class, 'custom')->create([
                'company_id'    => $employee->company_id,
                'branch_id'    => $employee->branch_id,
                'employee_id'    => $employee->id,
                'username'  => 'employee',
                'email'  => 'employee@example.com',
                'role'  => 'employee',
            ]);
        }
        
        $this->info('Super Admin Credentials - Username: super-admin | Email: super-admin@example.com | Password: password | Admin Credentials - Username: admin | Email: admin@example.com | Password: password | Employee Credentials - Username: employee | Email: employee@example.com | Password: password');
    }
}
