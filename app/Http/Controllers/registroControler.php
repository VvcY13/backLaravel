<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class registroControler extends Controller
{
    public function registrar(Request $request){
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8']);

        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        return response()->json(['message' =>'Usuario Creado Correctamente','user'=> $user], 201);
    }
}
