<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class demoapi_controller extends Controller
{
    protected $data;
    protected $db;
    protected $other;

// start user register
public function registerdata(Request $request){
       try{
       
           $validation = Validator::make($request->all(),[ 
               'name' => 'required',
               'mobile' => 'required|unique:users,mobile|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10',
               'dob' => 'required',
               'gender' => 'required',
           ]);
       
           if($validation->fails()){
               return response(array("status"=>false,"message"=>$validation->errors()),401)->header("Content-Type","application/json");  
       
           } else{
             $this->data=User::create($request->all());
             if($this->data){
               return response(array("status"=>true,"message"=>" Registered Successfully"),200)->header("Content-Type","application/json");  
       
             }
             else{
               return response(array("status"=>false,"message"=>"Server down, please try again later"),401)->header("Content-Type","application/json");  
             }
           }
   }
   catch(QueryException $error){
      return response(array("status"=>false,"message"=>"Opps! Technical error Accured."),401)->header("Content-Type","application/json");
   }
}
}
