<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = DB::table('users')->select()->get();
        // $users = DB::select("select * from users where id =2");
        if (count($users) == 0) {
            $output['error'] = true;
            $output['data'] = 'No Users found';
            return response()->json($output);
        } else {
            $output['error'] = false;
            $output['data'] = $users;
            return response()->json($output);
        }

    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|min:2',
            'email' => 'required|unique:users|email:rfc',
            'phone' => 'required|max:10|min:10|unique:users',
            'city' => 'required',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $output['error'] = true;
            $output['data'] = $validator->errors()->first();
            return response()->json($output);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->city = $request->city;
            $user->save();
            $output['error'] = false;
            $output['data'] = $user;

            return response()->json($output);
        }

    }
}
