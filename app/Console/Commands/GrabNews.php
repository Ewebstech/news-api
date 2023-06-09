<?php

namespace App\Console\Commands;

use App\Services\InitFeeds;
use Illuminate\Console\Command;


class GrabNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will grab news from feed sources';

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
        InitFeeds::getFeedData();
        echo "Content Imported \n";
    }
}
