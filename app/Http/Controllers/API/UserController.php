<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $data = UserResource::collection($users);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);            
        
        $userToken = $user->createToken('auth_token')->plainTextToken;
       
        return response()->json([
            'token_access' => $userToken,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
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

    public function userLogin(Request $request)
    {
        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'message' => 'Invalid email or password, try again.'
            ], 401);            
        }

        $user = User::where('email','=', $request->email)->firstOrFail();
        $userToken = $user->createToken('auth_token')->plainTextToken;
       
        return response()->json([
            'token_access' => $userToken,
            'token_type' => 'Bearer'
        ]);
    }
}
