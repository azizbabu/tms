<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resetDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will drop all tables from database';

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
        //we are only authorized to run this logic if application is NOT in PRODUCTION

        if(in_array(env('APP_ENV'), ['production','Production','prod'])){
            $this->info('WARNING: Application is in PRODUCTION mode!');
            //we have nothing to do, let's go back to home...
            return false;
        }

        //we have job, let's do it...

        //db name from env
        $myDB = env('DB_DATABASE');

        //statement for select all table's name
        $tables = DB::select(DB::raw("SELECT table_name as name FROM information_schema.tables where table_schema='".$myDB."';"));

        //building table drop statement
        $tableCounter = 0;
        if(count($tables) > 0){
            $queryArray = [];
            foreach ($tables as $table) {
                $sql = "DROP table ".$table->name.";";
                $queryArray[] = $sql;
                $tableCounter++;
            }

            //make a single statement
            $dropSql = implode(' ', $queryArray);

            //executing statement
            DB::getPdo()->exec($dropSql);

            //publishing success message
            $this->info($tableCounter.' tables has been successfully dropped.');
        }else{
            //database is already empty
            $this->info('No tables has been found.');
        }
    }
}
