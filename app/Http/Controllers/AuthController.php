<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Models\Users;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4',
            'password' => 'required|min:6'
        ],
        [
            'required'  => ':attribute harus diisi',
            'min'       => ':attribute minimal :min karakter',
        ]);

        if ($validator->fails()) {
            $resp = [
                'metadata' => [
                        'message' => $validator->errors()->first(),
                        'code'    => 422
                    ]
                ];
            return response()->json($resp, 422);
            die();
        }

        $user = Users::where('username', $request->username)->first();
        if($user)
        {
            if( Crypt::decrypt($user->password) == $request->password)
            {
                
                $token = \Auth::login($user);
                $resp = [
                    'response' => [
                        'token'=> $token  
                    ],
                    'metadata' => [
                        'message' => 'OK',
                        'code'    => 200
                    ]
                ];

                return response()->json($resp);
            }else{

                $resp = [
                    'metadata' => [
                        'message' => 'Username Atau Password Tidak Sesuai',
                        'code'    => 401
                    ]
                ];

                return response()->json($resp, 401);
            }
        }else{
            $resp = [
                'metadata' => [
                    'message' => 'Username Atau Password Tidak Sesuai',
                    'code'    => 401
                ]
            ];

            return response()->json($resp, 401);
        }

    }

}
