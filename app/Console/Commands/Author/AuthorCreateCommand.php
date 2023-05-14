<?php

namespace App\Console\Commands\Author;

use App\Models\Author;
use Illuminate\Console\Command;
use App\Services\SkeletonService;

class AuthorCreateCommand extends Command
{

    private SkeletonService $skeleton;

    public function __construct(SkeletonService $skeleton)
    {
        $this->skeleton = $skeleton;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:create';

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
        $getToken = session('accessToken');

        if(isset($getToken)){
            // For creating author we can write here user email and password directly to login and get token
            return $this->error('User is not logged in.');
        }

        $first_name = $this->ask('Enter author First name?');
        $last_name = $this->ask('Enter author Last name?');
        $birthday = $this->ask('Enter author birthday in [DD/MM/YYYY]?');
        $biography = $this->ask('Enter author biography');
        $gender = $this->ask('Enter author gender?');
        $place_of_birth = $this->ask('Enter author place_of_birth?');

        if (is_null($first_name) || is_null($last_name)) {
            return $this->error('First  or Last name cannot be null.');
        }

        $requestData = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "birthday" => $birthday,
            "biography" => $biography,
            "gender" => $gender,
            "place_of_birth" => $place_of_birth
        ];

        $response = $this->skeleton->createAuthor($requestData, $getToken);

        if($response['status_code'] == 200){
            $this->info("Author $first_name.' '. $last_name successfully created.");
        }
    }
}
