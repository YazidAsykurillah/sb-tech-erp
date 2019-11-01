<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;
use Storage;
use DB;
class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database of the application daily';

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
        $this->info($this->description);
        //set filename with date and time of backup
        $filename = env('DB_DATABASE')."_". Carbon\Carbon::now()->format('Y-m-d_H-i-s') . ".sql";

        //mysqldump command with account credentials from .env file. storage_path() adds default local storage path
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/" . $filename;

        $returnVar = NULL;
        $output  = NULL;
        //exec command allows you to run terminal commands from php 
        exec($command, $output, $returnVar);

        //if nothing (error) is returned
        if(!$returnVar){
           $this->info("Backup completed");
           $this->info($filename);
            
        }else{
            $this->error("Backup failed");
        }

       
    }
}
