<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Validator;

use App\Company;
use App\ScheduledEmail;

use Illuminate\Validation\Rule;
use DB;

use Mail;


class SendEmailController extends Controller
{
    public function getSendEmailPage(){
        return view('send_email');
    }

    public function sendEmail(Request $request){
        $data = $request->all();
        
        $request->validate([
            'from_name' => 'required',
            'from_email' => 'required|regex:/^.+@.+$/i',
            'to_name' => 'required',
            'to_email' => 'required|regex:/^.+@.+$/i',
            'message' => 'required',
            'type' => 'required'
        ]);

        $flag = false;
        if($data['type'] == 2){
            $flag = true;
            $email =  ScheduledEmail::create([
                'from_name' => $data['from_name'],
                'from_email' => $data['from_email'],
                'to_name' => $data['to_name'],
                'to_email' =>$data['to_email'],
                'message' => $data['message'],
                'sched_date' => $data['sched_date'],
            ]);
        }else{
            $flag = true;
            $send_to = $data['to_email'];
    
            Mail::send('send_email_format' , ['data' => $data, ], function($message) use ($send_to, $data){
                $message->to($send_to);
                $message->subject('Email Notification');
            });
        }

        $statusCode = -1;
    	if($flag){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	return $data_response;
    }
}
