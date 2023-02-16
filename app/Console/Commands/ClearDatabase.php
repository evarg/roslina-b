<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Packet;
use App\Models\Producer;


class ClearDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roslina:clear-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear database';

    private $storage;

    /**
     * Create a new command instance.
     *
     * @param Storage $storage
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
        User::truncate();
        Packet::truncate();
        Producer::truncate();
    }
}
