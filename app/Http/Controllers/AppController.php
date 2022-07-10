<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speech;
use Validator;

class AppController extends Controller
{
    
    public function __construct()
    {
        //
    }

     
    /**
     * Store a speech to text.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'text_data'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        return response()->json([
            'fail' => true,
            'errors' => $validator->errors()
        ]);

        $inputData = new Speech;

        $inputData->text_data = $request->input('text_data');
        $inputData->save();
       
        return response()->json([
            'fail' => false,
            'message' => ''
            ]);
        
    }


}
