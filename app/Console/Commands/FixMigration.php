<?php

namespace App\Console\Commands;

use Storage;
use Illuminate\Console\Command;

class FixMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix migrations table';

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

    protected function getLatesMigrationFromDatabase()
    {
        $result = [];

        $count = \DB::table('migrations')->count();
        if($count!=0){
            $migrations = \DB::table('migrations')->get();
            foreach($migrations as $migration){
                $result =[
                    'migration'=>$migration->migration,
                    'batch'=>$migration->batch
                ] ;
            }
        }
        return $result;
    }
    protected function obtainMigrationFiles()
    {
        
    }

    public function handle()
    {
        $latestMigrationFromDatabase = $this->getLatesMigrationFromDatabase();
        $latestMigrationFileName = $latestMigrationFromDatabase['migration'];
        $latestBatch = $latestMigrationFromDatabase['batch'];
        //print_r($latestMigrationFromDatabase);exit();

        $this->info($this->description);

        $migration_path = base_path('database/migrations');
        foreach (glob($migration_path.'/*.php') as $file) {
            $filename = basename($file,'.php');
            if($filename == $latestMigrationFileName){
                echo "$filename" . "\n";    
            }
            
        }
    }
}
