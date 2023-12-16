<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>['required','string','max:120'],
            'email'=>['required','email','max:120'],
            'subject'=>['required','string'],
            'message'=>['required','string','max:255'],
        ]);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator->errors())->with('error','Please Check your input and try again');
        }

        Enquiry::create($validator->validated());
        return back()->with('success','Thank you for reaching out! We\'l get to you soon!');
    }
}
