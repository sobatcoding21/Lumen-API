<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Models\Users;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $data = Users::get();
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Users::where('id', $id)->first();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name'        => 'required',
                'address'     => 'required',
                'phone'       => 'required',
            ],
            [
                'name'  => ':attribute harus diisi',
                'address'   => ':attribute harus angka',
                'phone'     => ':attribute minimal :min karakter',
            ]);

        if ($validator->fails()) {
           
            return response()->json($validator->errors()->first(), 400);
            die();
        }

        $data = new Users;
        $data->name = $request->post('name');
        $data->address = $request->post('address');
        $data->phone = $request->post('phone');
        $data->save();

        return response()->json($data, 201);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'id'        => 'required',
                'name'      => 'required|nullable',
                'address'   => 'required|nullable',
                'phone'     => 'sometimes|nullable',
            ]);

        if ($validator->fails()) {
           
            return response()->json($validator->errors()->first(), 400);
            die();
        }

        $data = Users::where('id', $request->post('id'))->first();
        if( $data )
        {
            $data->name = $request->post('name') ? $request->post('name') : $data->name;
            $data->address = $request->post('address') ? $request->post('address') : $data->address;
            $data->phone = $request->post('phone') ? $request->post('phone') : $data->phone;
            $data->save();
    
            return response()->json($data, 200);
        }else{
            return response()->json("Data tidak ditemukan", 400);
        }
        

    }

    public function destroy($id)
    {
        
        $data = Users::where('id', $id)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

}