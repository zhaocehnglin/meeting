<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class meetcontroller extends Controller
{
    public function register(Request $Request)
    {	$bool1=DB::select("select* from user where name=?",[$Request->get('name')]);
    	$bool2=DB::select("select* from user where email=?",[$Request->get('email')]);
    	if($bool1||$bool2)
    	{
    		return response()->json(["state"=>"fail1"]);
    	}
    	else
    	{
    		$inputs['email']=$Request->get('email');
        //dd($inputs['email']);
    		$inputs['name']=$Request->get('name');
    		$inputs['password']=$Request->get('password');
    		$inputs['code']=str_random(8);
    		$user=new \App\users();
    		$user->create($inputs);
    		$data=['email'=>'1485846902@qq.com','name'=>'zhao','code'=>'123456'];
    		Mail::send('activemail',$data,function($message)use($data)
    		{
    			$message->to($data['email'],$data['name'])->subject("欢饮注册会议室管理系统");
    		});
       return response()->json(["state"=>"wating"]);
    	}
   
   }
   public function active ($email,$code)
   {
   		$user=DB::select("select * from user where email=?",[$email]);
   		$mycode=$user[0]->code;
   		$password=$user[0]->password;
   		if($mycode==$code)
   		{
   			$new_password=Hash::make($password);
   			$test=DB::update("update user set password=?",[$new_password]);
   			return response()->json(["state"=>"success"]);
   		}
   		else
   		{
   			$test2=DB::delete("delete from user where email=?",[$email]);
   			return response()->json(["state"=>"fail2"]);
   		}
   }
   public function login(Request $Request)
   {
   		$name=$Request->get("name");
   		//$email=$Request->get("email");
   		$password=$Request->get("password");
   		$result1=DB::table("user")->where("email",$name)
   								  ->orwhere('name',$name)
   								  ->get();
   		if(!$result1)
   		{
   			return response()->json(["state"=>"fail1"]);
   		}
   		else
   		{
   			$result2=DB::table("user")->where("name",$name)->get();
   			$bool=Hash::check($password,$result2[0]->password);
   			if($bool)
   			{
   				return response()->json(["state"=>"success"]);
   			}
   			else
   			{
   				return response()->json(["state"=>"fail2"]);
   			}
   		}
   }
   public function addmeet(Request $Request)
   {
   		$inpus=$Request->all();
   		$skip=$Request->get("skip");
   		$localtion=$Request->get("localtion");
   		$startdate=$Request->get("startdate");
   		$starttime=$Request->get("starttime");
   		$meeting=new \App\meeting();
   		if($skip==1)
   		{
   			$result=DB::table("meeting")->where("start",$startdate)
   										->andwhere("starttime",$starttime)
   										->andwhere("localtion",$localtion)
   										->get();
   			if($result)
   			{
   				return response()->json(["state"=>"fail"]);
   			}
   			else
   			{
   				$meeting->create($inputs);
   				return response()->json(["state"=>"success"]);
   			}
   		}
   		else
   		{
   				$meeting->create($inputs);
   				return response()->json(["state"=>"success"]);
   		}
   }
   public function meeting(Request $Request)
   {
   		//$date=$Request->get("date");
   		//$gets=DB::table('meeting')->where("start")s
   		//$time=time();
   		//$now=date("y-m-d",$time);
   		//dd($now);
   		$date=$Request->get("date");
   		if($date=="day")
   		{
   			$gtes=DB::select("select * from meeting where date(start)=date(now())");
   			return response()->json(["meeting"=>$gets]);
   		}
   		//$get=DB::table("meeting")->where("start",$now)->get();
   		if($date=="month")
   		{
   			$gets=DB::select("select * from meeting where month(start) =

			month(curdate()) and year(start) = year(curdate())");
			return response()->json(["meeting"=>$gets]);
   		}
   		if($date=="week")
   		{
   			$gets=DB::select("select * from meeting where week(start) = week(now)");
   			return response()->json(["meeting"=>$gets]);
   		}
   }
   public function detial($id)
   {

   		$gets=DB::table("meeting")->where("id",$id)-get();
   		if(!$gets)
   			{
   				return response()->json(["$get"=>"fail"]);
   			}
   		return response()->json(["$get"=>$gets]);
   }
   public function room(Request $Request)
   {
   		$localtion=$Request->get("localtion");
   		$number=$Request->get("number");
   		$gets=DB::table("meetroom")->where("localtion",$localtion)
   									->andwhere("number",$number)
   									->get();
   		if(!$gets)
   		{
   			return response()->json(["get"=>"fail"]);
   		}
   		return response()->json(["gets"=>$gets]);
   }
   public function editroom(Request $Request)
   {
   		$inputs=$Request->all();
   		room::create($inputs);
   		return 	response()->json(["state"=>"success"]);
   }
}