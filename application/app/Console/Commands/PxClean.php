<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
class PxClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pxclean:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('route:clear');
        $this->info('Route cleard');
        Artisan::call('view:clear');
        $this->info('View cleard');
        Artisan::call('config:clear');
        $this->info('Config cleard');
        Artisan::call('cache:clear');
        $this->info('Cache cleard');
        Artisan::call('config:cache');
        $this->info('Config cached');
        Artisan::call('optimize');
        $this->info('Optimazation done');

    }
}
