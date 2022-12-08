<?php

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Http\Controllers\UserController;

class Register extends Command
{
    private $userController;
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
    public function __construct(UserController $userController)
    {
        parent::__construct();
        $this->userController=$userController;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->userController->insert();
    }
}
