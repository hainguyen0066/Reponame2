<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MysqlBackupCommand extends Command
{
    protected $targetDir = "~/backup/";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:backup {connection} {--targetDir=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup a Mysql database by the specific connection name.';

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
        $connectionName = $this->argument('connection');
        try {
            $connections = config('database.connections');
            if (!$connectionName || !isset($connections[$connectionName])) {
                throw new \InvalidArgumentException();
            }
            \DB::connection($connectionName);
            $connection = $connections[$connectionName];
            $this->output->title("Process backing up connection `{$connectionName}`, database: `{$connection['database']}`");
            if ($targetDir = $this->option('targetDir')) {
                $this->targetDir = $targetDir;
            }
            $targetFile = $this->getTargetFilePath($connection['database']);
            exec("mysqldump -p{$connection['password']} -u {$connection['username']} -h {$connection['host']} -P {$connection['port']} {$connection['database']} > {$targetFile}", $output, $result);
            if (1 || $output === 0) {
                $this->output->success("Database connection `{$connectionName}` was backed up successfully as `{$targetFile}`.");
            } else {
                $this->output->error("Failed in creating backup " . PHP_EOL  . implode(PHP_EOL, $output));
            }
        } catch (\InvalidArgumentException $e) {
            $this->output->error("Cannot connect to the specific connection");
        }
    }

    /**
     * @param $database
     *
     * @return string
     */
    private function getTargetFilePath($database)
    {
        $time = date('YmdHi');
        return $this->targetDir . "{$database}_{$time}.sql";
    }
}
