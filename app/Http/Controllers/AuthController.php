<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login']]);
    }

    /**
     * @desc Genera un JWT con las credenciales
     * @author Juan Pablo Camargo Vanegas
     * @param  Request  $request
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'incorrect email or password'], 400);
        }

        return $this->responseSuccess($this->respondWithToken($token));
    }

    /**
     * @desc obtiene los datos del usuario autenticado
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @desc Invalida el token actual del usuario.
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @desc Renueva el token del usuario
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->responseSuccess($this->respondWithToken(auth()->refresh()));
    }

    /**
     * @desc Valida el token que se usa en el consumo
     * @author Juan Pablo Camargo Vanegas
     * @return void
     */
    public function getAuthenticatedUser(){
        try {
            if(! \auth()->check()){
                return $this->responseFail(['message' => 'User not found'],Response::HTTP_NOT_FOUND);
            }
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return $this->responseFail(['message' => 'Token expired'], Response::HTTP_UNAUTHORIZED);
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return $this->responseFail(['message' => 'Token invalid'], Response::HTTP_UNAUTHORIZED);
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e){
            return $this->responseFail(['message' => 'Token absent'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->responseSuccess([
            'user' => \auth()->user()->user,
            'email' => \auth()->user()->email
        ]);
    }

    /**
     * @desc Retorna la estructora con el token
     * @author Juan Pablo Camargo Vanegas
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user_id' => \auth()->user()->id,
            'email' => auth()->user()->email,
            'user' => \auth()->user()->name,
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ];
    }
}
