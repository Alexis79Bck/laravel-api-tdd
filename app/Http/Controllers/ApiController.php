<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    /**
     * Get the list of All Users in DB
     *
     * @param Request $request
     * @return void
     */
    public function users(Request $request) {
        if ($request->has('active')) {
            $users = User::where('active',true)->get();
        } else {
            $users = User::all();
        }

        return response()->json($users);

    }

    public function login(Request $request) {
        $response = [
            'status' => 0,
            'message' => ''
        ];

        $data = json_decode($request->getContent());
        $user = User::where('email','=',$data->email)->first();
         
        if ($user) {
           if (Hash::check($data->password, $user->password)) {
                $token = $user->createToken('Welcome');
                $response['status'] = 1;
                $response['message'] = $token->plainTextToken;
           } else {
            $response['message'] = 'Las credenciales son incorrectas.';
           }
        } else {
           $response['message'] = 'Usuario no existe.';
        }

        return response()->json($response);
    }
}
