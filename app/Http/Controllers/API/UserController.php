<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
       $validate = $this->validateData($request);

       $user = User::create([
            'fullname' => $validate['fullname'],
            'email' => $validate['email'],
            'username' => $validate['username'],
            'password' => Hash::make($validate['password'])
       ]);
       
       $user->save();


        return response()->json([
            "Status" => 1,
            "Data" => $user->toArray(),
            "Msg" => "Registro Exitoso."
            ]);

    }
    public function login(Request $request)
    {
        //
    }
    public function profile()
    {
        //
    }
    public function logout()
    {
        //
    }

    public function validateData(Request $request)
    {
        return $request->validate([
            'fullname' => 'required|string|max:50',
            'email' =>  'required|string|email|unique:users',
            'username' => 'required|string|min:8',
            'password'=> 'required|confirmed'
        ]);
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
