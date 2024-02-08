<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Function to register a user
    public function register(Request $request)
    {
        //Indicate only the data to be received on request
        $data = $request->only(
            'email',
            'password',
            'privilegio',
            'rol',
            'estado',
            'foto'
        );

        //Data validation
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:50',
            'privilegio' => 'required|numeric',
            'rol' => 'required|string',
            'estado' => 'required|numeric',
            'foto' => 'required|string'
        ]);

        //Return an error if validations fail
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create new user
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'privilegio' => $request->privilegio,
            'rol' => $request->rol,
            'estado' => $request->estado,
            'foto' => $request->foto
        ]);

        //Save the user and password to perform the token request to JWTAuth
        $credentials = $request->only('email', 'password');

        //Return response with user token
        return response()->json([
            'message' => 'Usuario creado',
            'token' => JWTAuth::attempt($credentials),
            'user' => $user
        ], Response::HTTP_OK);
    }

    //Function to login
    public function authenticate(Request $request)
    {
        //Fetch only email and password of the request
        $credentials = $request->only('email', 'password');

        //Data validation
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:50'
        ]);

        //Return an error if validations fail
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Log in
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                //Incorrect credentials.
                return response()->json([
                    'mensaje' => 'Error de inicio de sesión',
                ], 401);
            }
        } catch (JWTException $e) {
            //If a JWTException
            return response()->json([
                'message' => 'Error',
            ], 500);
        }

        //Return token
        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    //Function to remove the token and disconnect the user
    public function logout(Request $request)
    {
        //Validate if we have been sent the token
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Return an error if validations fail
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        try {
            //If the token is valid, we delete the token and disconnect the user
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'Usuario desconectado'
            ]);
        } catch (JWTException $e) {
            //If a JWTException
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    //Function that obtains the user's data and validates if the token has expired.
    public function getUser(Request $request)
    {
        //Validate token in the request
        $this->validate($request, [
            'token' => 'required'
        ]);

        //Verify authentication
        $user = JWTAuth::authenticate($request->token);
        //If there is no user, the token is invalid or expired
        if (!$user)
            return response()->json([
                'message' => 'Invalid token / token expired',
            ], 401);
        //Return user data if user exists 
        return response()->json(['user' => $user]);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for user
        $user = User::findOrfail($id);

        //Delete user
        $user->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'EL usuario fue eliminado con exito'
        ], Response::HTTP_OK);
    }
}
