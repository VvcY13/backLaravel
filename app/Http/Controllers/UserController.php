<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Type\FalseType;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json(['message' => 'Personal', 'Personal' => $user], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(UserStoreRequest $request)
    {
        $validatedData = $request->validated();
        
        $user = new User();
        $user->nombres = $validatedData['nombres'];
        $user->apellidos = $validatedData['apellidos'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->direccion = $validatedData['direccion'];
        $user->provincia = $validatedData['provincia'];
        $user->distrito = $validatedData['distrito'];
        $user->tipo_documento = $validatedData['tipo_documento'];
        $user->numero_documento = $validatedData['numero_documento'];
        $user->rol = true;
        $user->estado = false;
        $user->save();

        $token = JWTAuth::fromUser($user);


        return response()->json(['message' => 'Personal Registrado', 'Personal' => $user, 'Token' => $token], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
       
    }


   
    public function update(UserUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        
        $user = User::findOrFail($id);
        
        $user = User::findOrFail($id);
        $user->nombres = $validatedData['nombres'];
        $user->apellidos = $validatedData['apellidos'];
        $user->email = $validatedData['email'];
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->direccion = $validatedData['direccion'];
        $user->provincia = $validatedData['provincia'];
        $user->distrito = $validatedData['distrito'];
        $user->tipo_documento = $validatedData['tipo_documento'];
        $user->numero_documento = $validatedData['numero_documento'];
        $user->save();

        $token = JWTAuth::fromUser($user);
        
        return response()->json(['message' => 'Usuario actualizado', 'User' => $user, 'Token' => $token], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $user->delete();
    
        return response()->json(['message' => 'Usuario eliminado correctamente']);
        
    }
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
            $user = auth()->user();
            $rol = $user->rol;
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo generar el token'], 401);
        }


        return response()->json(['token' => $token, 'rol' => $rol]);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json(['mensaje' => 'Sesión cerrada'], 200);
    }
}
