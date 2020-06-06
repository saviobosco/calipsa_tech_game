<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_blog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $entryData = array(
            'category' => 'kittensCategory'
        , 'title'    => 'Hello World'
        , 'article'  => 'Hello Johnbosco'
        , 'when'     => time()
        );


        // This is our new stuff
        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://".env('PHP_APP_IP').":5555");

        $socket->send(json_encode($entryData));
    }
}
