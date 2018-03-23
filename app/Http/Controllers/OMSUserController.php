<?php

namespace App\Http\Controllers;


use Response;
use Validator;
use Illuminate\Support\Facades\DB;

class OMSUserController extends Controller
{



    public function addUser(Request $request)
    {
          $name = $request->input('name');
          $firstname = $request->input('firstname');
          $lastname = $request->input('lastname');
          $usermail = $request->input('usermail');
          $username = $request->inputt('username');
          $role = $request->input('userrole');
          $userpasse = $request->input('userpasse');
          $phonenumber = $request->input('phonenumber');
          $disabled = 0;

          $user = new User();
          $user->name = $username;
          $user->firstname = $firstname;
          $user->lastname = $lastname;
          $user->passsword = $userpasse;
          $user->phonenumber = $phonenumber;
          $user->name = $name;
          $user->disabled = $disabled;
          $user->email = $usermail;

        $user->save();

        $userid = DB::table('user')->where('user.name','=',$username)
            ->select('user.id')->pluck('id')->first();

          $personal = new Personal();
          $personal->firstname = $firstname;
          $personal->lastname = $lastname;
          $personal->user_id = $userid;





          $disabled = 0;

    }
}