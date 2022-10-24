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
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:50',
            'email' => 'required|email|string|max:50|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'active' => true
        ]);

        $userToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'New User have been registered.',
            'userInfo'=> $user->only('id','name','email','active'),
            'token_access' => $userToken,
            'token_type' => 'Bearer'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =User::findOrFail($id);
        return response()->json([
            'userInfo'=>  new UserResource($user)
        ], 200);
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
        $user = User::findOrFail($id);
        $oldUser = $user;
        $user->fill($request->toArray())->save();

        return response()->json([
            'oldUserInfo' => new UserResource($oldUser),
            'newUserInfo'=> new UserResource($user)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        return response()->json([
            'message' => 'The user record have been deleted successfully.',
            'name' => $name,
        ]);
    }

    public function userLogin(Request $request)
    {

        return response()->json($this->attemptLogin($request));

    }

    public function userProfile(Request $request)
    {
        
        return $request->user();
    }

    private function attemptLogin($request)
    {
        if (Auth::attempt($request->only('email','password'))) {
            $user = User::where('email','=', $request->email)->firstOrFail();
            $userToken = $user->createToken('auth_token')->plainTextToken;
            return [
                'message' => 'Login successfully.',
                'status'=>'Granted',
                'userInfo'=> $user->only('id','name','email'),
                'token_access' => $userToken,
                'token_type' => 'Bearer'
                ];
        }else{
            return [
                'message' => 'Invalid email or password, try again.',
                'status'=>'Denied'
                ];
        }

    }
}
