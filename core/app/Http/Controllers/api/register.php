<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;

class register extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|min:3|max:100',
            'password' => 'required|min:3|max:200',
        ]);
        
        if($validator->fails())
            {   
                // DIEKSEKUSI SAAT TIDAK MELEWATI VALIDATOR
                $respon = (Object)[
                    "status" => 401,
                    "errors" => "TERJADI KESALAHAN"
                ];
                $respon = \json_encode($respon);
                return $respon;
            }

        $hs_password =  \md5($request->password);
        $user = User::where("username",$request->username)->where("password",$hs_password)->first();

        if($user == null){
                // DIPANGGIL SAAT TIDAK ADA USERNAME ATAU PASSWORD YANG COCOK
                $respon = [
                    "status" => 403,
                    "errors" => "TIDAK ADA CREDENTIALS YANG COCOK"
                ];
                
                return response()->json($respon);
        }else{
                // DIPANGGIL SAAT BERHASIL
                $respon = [
                    "status" => 200,
                    "user_id" => $user->id,
                    "username" => $user->username,
                    "userfullname" => $user->full_name,
                    "message" => "SUCESS MASUK"
                ];
                
                return response()->json($respon);
        }
    
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "full_name" => "required|min:3|max:150|unique:users,full_name",
            "username" => "required|min:3|max:100|unique:users,username",
            "no_telp" => "required|numeric|min:3|digits_between:0,15|unique:users,no_telp",
            "bio" => "required|min:3|max:100",
            "password" => "required|min:3|max:100",
        ]);

        if($validator->fails())
        {   
            $respon['status'] = 403;

            $errors = $validator->errors();
            if($errors->has("full_name")){
                $respon['full_name'] = $errors->first('full_name');
            }
            if($errors->has("username")){
                $respon['username'] = $errors->first('username');
            }
            if($errors->has('no_telp')){
                $respon['no_telp'] = $errors->first('no_telp');
            }
            if($errors->has('bio')){
                $respon['bio'] = $errors->first('bio');
            }
            if($errors->has('password')){
                $respon['password'] = $errors->first('password');
            }

            return response()->json($respon);
        }

        $user = new User;
        $user->full_name = $request->full_name;
        $user->username = $request->username;
        $user->no_telp = $request->no_telp;
        $user->bio = $request->bio;
        $user->password = \md5($request->password);
        $user->save();

        $respon = (Object)[
            "status" => 200
        ];
        $respon = \json_encode($respon);
        return $respon;
    }

    public function tokenFeeder(Request $request){
        // RESET TOKEN
            $user_current_token = User::where('token',$request->token)->first();


                $user_current_token->token = null;
                $user_current_token->save();

        // AKHIR

        $user = User::find($request->user_id);

        if($user != null){
            $user->token = $request->token;
            $user->save();
            return \response()->json(["status" => 200],200);
        }

        return \response()->json(["status" => 403],200);

    }
    
}
