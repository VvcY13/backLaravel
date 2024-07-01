<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personal = Personal::all();
        return response()->json(['message' => 'Personal', 'Personal'=>$personal], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nombres'=> 'required|string|max:255',
            'apellidos'=>'required|string|max:255',
            'correo'=>'required|string|max:255',
            'contraseña'=>'required|string|max:255',
            'direccion'=>'required|string|max:255',
            'provincia'=>'required|string|max:255',
            'distrito'=>'required|string|max:255',
            'tipo_documento'=>'required|numeric|max:255',
            'numero_documento'=>'required|string|max:255',
            
        ]);
      


        $personal = new Personal();
        $personal->nombres = $validatedData['nombres'];
        $personal->apellidos = $validatedData['apellidos'];
        $personal->correo = $validatedData['correo'];
        $personal->contraseña = $validatedData['contraseña'];
        $personal->direccion = $validatedData['direccion'];
        $personal->provincia = $validatedData['provincia'];
        $personal->distrito = $validatedData['distrito'];
        $personal->tipo_documento = $validatedData['tipo_documento'];
        $personal->numero_documento = $validatedData['numero_documento'];
        $personal->rol = true;
        $personal->estado = false;
        $personal->save();

        $token = JWTAuth::fromUser($personal);


        return response()->json(['message'=>'Personal Registrado','Personal'=>$personal,'Token'=>$token],201);

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function login(Request $request){
        $credentials = $request->only('correo', 'contraseña');

        try{
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
                }
        }catch(JWTException $e){
            return response()->json(['error' => 'No se pudo generar el token'], 401);
        }
        return response()->json(['token'=>$token]);
    }
    public function logout(){
        Auth::logout();
        return response()->json(['mensaje'=>'Sesión cerrada'],200);
    }
}
