<?php

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;

class Register extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command for user registration';

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
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
