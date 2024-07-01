<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\detallesVentas;
use App\Models\ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ventasController extends Controller
{
    public function index()
    {
        $ventas = ventas::with('detalles.producto')->get();

    return response()->json($ventas);
    }
    public function userSales(){
        $user = auth()->user();
        $ventas = ventas::where('id_personal', $user->id)
                        ->with('detalles.producto')
                        ->get();
        return response()->json($ventas);
    }

    public function create()
    {
        $user = auth()->user();
        $carrito = Carrito::with('detalles.producto')->where('id_personal',$user->id)->first();
        Log::info($carrito);

        if(!$carrito || $carrito->detalles->isEmpty()){
            return response()->json(['message'=>'Carrito Vacio'],404);
        }
        DB::beginTransaction();
        try{
            $venta = ventas::create([
                'id_personal'=>$user->id,
                'total'=> $carrito->detalles->sum(function($detalle){
                    return $detalle->cantidad*$detalle->precio;
                })
            ]);
            foreach($carrito->detalles as $detalle){
                if ($detalle->id_producto) {
                    detallesVentas::create([
                        'id_venta'=>$venta->id,
                        'id_producto'=>$detalle->id_producto,
                        'cantidad'=>$detalle->cantidad,
                        'precio'=>$detalle->precio,
                    ]);
                } else {
                    return response()->json(['message'=>'El ID del producto es nulo para un detalle de venta'], 500);
                }
            }
            $carrito->detalles()->delete();
            $carrito->delete();

            DB::commit();

            return response()->json([
                'message' => 'Compra Realizada con Exito',
                'carrito' => [
                    'detalles' => []
                ],
                'totalCantidad' => 0,
                'totalMonto' => 0
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'Error al realizar la compra','error'=>$e->getMessage()],500);
        }
    }
 
    public function store(Request $request)
    {
        //
    }
 
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
