<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PermissionCacheReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:cache-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dummy command for deployment compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Permission cache reset command executed (no-op).');
        return 0;
    }
}

