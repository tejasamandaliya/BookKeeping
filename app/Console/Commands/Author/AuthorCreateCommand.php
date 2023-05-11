<?php

namespace App\Console\Commands\Author;

use App\Models\Author;
use Illuminate\Console\Command;

class AuthorCreateCommand extends Command
{
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
        $name = $this->ask('Enter author name?');
        $email = $this->ask('Enter author email?');
        if (is_null($name) || is_null($email)) {
            return $this->error('Name or Email cannot be null.');
        }
        $author = Author::where('email', $email)->first();
        if ($author) {
            return $this->error('Author with this email id already exists.');
        } else {
            $author = new Author;
            $author->name = $name;
            $author->email = $email;
            $author->save();
            $this->info("Author $name successfully created.");
        }
    }
}
