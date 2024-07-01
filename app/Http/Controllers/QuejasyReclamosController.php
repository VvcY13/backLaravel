<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QuejasyReclamos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuejasyReclamosController extends Controller
{
    public function index()
    {
        $quejasyreclamos = QuejasyReclamos::all();
        return response()->json(['message' => 'quejasyreclamos', 'quejasyreclamos' => $quejasyreclamos], 200);
    }
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_personal' => 'required|exists:users,id',
                'asunto' => 'required|in:Quejas,Sugerencias,Opiniones',
                'comentario' => 'required|string|max:255'
            ]);
            Log::info('Datos recibidos', $validatedData);
            $quejasyreclamos = new QuejasyReclamos();
            $quejasyreclamos->id_personal = $validatedData['id_personal'];
            $quejasyreclamos->asunto = $validatedData['asunto'];
            $quejasyreclamos->comentario = $validatedData['comentario'];
            $quejasyreclamos->save();

            return response()->json(['message' => 'Mensaje enviado', 'mensaje' => $quejasyreclamos], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar el reclamo:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al guardar el reclamo: ' . $e->getMessage()], 500);
        }
    }
    public function show($id_personal)
    {
        try {
            $quejasyreclamos = QuejasyReclamos::where('id_personal', $id_personal)->get();

            if ($quejasyreclamos->isEmpty()) {
                return response()->json(['message' => 'No hay quejas encontradas para este usuario'], 404);
            }

            return response()->json(['message' => 'Quejas encontradas', 'data' => $quejasyreclamos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar quejas: ' . $e->getMessage()], 500);
        }
    }
    public function showPorAsunto($asunto)
    {
        try {
            $validatedData = [
                'asunto' => $asunto,
            ];
    
            $quejasyreclamos = QuejasyReclamos::where('asunto', $asunto)->get();
    
            if ($quejasyreclamos->isEmpty()) {
                return response()->json(['message' => 'No hay quejas encontradas con este asunto'], 404);
            }
    
            return response()->json(['message' => 'Quejas encontradas', 'data' => $quejasyreclamos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar quejas: ' . $e->getMessage()], 500);
        }
    }
}
