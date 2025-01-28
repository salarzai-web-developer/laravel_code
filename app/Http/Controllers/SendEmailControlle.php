<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailControlle extends Controller
{

     public function send(Request $request){

          $to="sharifullahsalarzai36@gmail.com";
          $subject= "testing";
          $message= "how are you dear?";

          $result=Mail::to($to)->send(new Mailer($subject, $message));

          if( $result ){

             echo "Email sent successfully";
          }else{

             echo "Emai not sent successfully";
          }
     }
}
