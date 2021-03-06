<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register user';

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

        $user = User::where('email', $this->argument('login'))->first();
        if (! $user ) {

            $user  = new User();
            $user->email = $this->argument('login');
            $user->password = Hash::make($this->argument('password'));
            $user->save();

            $this->info('New user is created');

            $key =  new ApiKey();

            $key->key = Str::random(80);
            $key->user_id = $user->id;

            $key->save();

            $this->info('apikey - '.($key->apikey));

            return 0;

        }else{

            $this->info('User with '.$this->argument('login').' already exist');
            return 0;
        }

    }
}
