<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EnquiryMail;
use App\Mail\ReplyEnquiryMail;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    

    /**
     * Validate Enquiry Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEnquiry(Request $request)
    {
       $validate = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'subject' => ['required', 'string',  'max:255'],
        'message' => ['required', 'string'],
        'phone' => ['nullable', 'string']
       ]); 


       Mail::to('info@redstoneresort.in')->send(new EnquiryMail($request->all()));
       Mail::to($request)->send(new ReplyEnquiryMail($request->all()));

       return response()->json(['message'=>'Enquiry sent successfully']);
    }

    

    
}
