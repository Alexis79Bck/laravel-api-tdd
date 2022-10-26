<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Performs the registration of a new user.
     *
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
       $validate = $this->validateData($request,'register');

       $user = User::create([
            'fullname' => $validate['fullname'],
            'email' => $validate['email'],
            'username' => $validate['username'],
            'password' => Hash::make($validate['password'])
       ]);

        return response()->json([
            "Status" => 1,
            "Data" => $user->only('fullname','email','username'),
            "Msg" => "Registro Exitoso."
            ]);

    }
    /**
     * Performs the login of the user.
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $validate = $this->validateData($request,'login');

        $user = User::where('username', $validate['username'])->first();
        if (isset($user->id)   ){

            $info = $this->checkPasswordLogin($user, $validate['password']);

            return response()->json($info, $info['code_response']);
        }else{
            return response()->json([
                "code_response" => 404,
                "status" => 0,
                "Msg" => "El usuario no se encuentra registrado."
                ], 404);
        }
    }
    public function profile()
    {
       //
    }
    public function logout()
    {
        //
    }
    /**
     * Validates the data submitted in the type of request that sends it.
     * the type can be register o login.
     *
     * @param Request $request
     * @param string $type
     * @return mixed
     */
    private function validateData(Request $request,string $type)
    {
        if ($type === 'register'){
            $rules =[
                'fullname' => 'required|string|max:50',
                'email' =>  'required|string|email|unique:users',
                'username' => 'required|string|min:8',
                'password'=> 'required|confirmed'
            ];
        }else{
            $rules = [
                'username' => 'required|string',
                'password'=> 'required'
            ];
        }

        return $request->validate($rules);
    }
   /**
    * Check if the password typed and the password stored in the DB are the same.
    *
    * If both password are the same then create the token to user login,
    * else return The password does not match our records.
    *
    * @param User $user
    * @param string $inputPassword
    * @return array
    */
    private function checkPasswordLogin(User $user, string $inputPassword)
    {

        if (Hash::check($inputPassword, $user->password)) {
            $userToken = $user->createToken('auth_token')->plainTextToken;
            return [
                "code_response" => 200,
                "status" => 1,
                "token_access" => $userToken,
                "token_type" => 'Bearer',
                "Msg" => "Ha iniciado sesión exitosamente."

                ];

        }else{
            return [
                "code_response" => 401,
                "status" => 0,
                "Msg" => "La contraseña no coincide con nuestros registros."
                ];
        }

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
