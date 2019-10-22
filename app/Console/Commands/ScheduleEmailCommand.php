<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\ScheduledEmail;


use Mail;

class ScheduleEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule an email';

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
        $datenow = date('Y-m-d H:i');
        $emails = ScheduledEmail::all();

        foreach($emails as $item){
            $dateTime = date('d-m-Y H:i', strtotime($item->sched_date));
            if($dateTime == $datenow){
                $send_to = $item->to_email;
                Mail::send('send_email_format' , ['data' => $item, ], function($message) use ($send_to, $item){
                    $message->to($send_to);
                    $message->subject('Email Notification');
                });
            }else{
                continue;
            }
        }

    }
}
