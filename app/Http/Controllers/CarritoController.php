<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function addToCart(Request $request)
    {
        $user = auth()->user();

        $carrito = Carrito::firstOrCreate(['id_personal' => $user->id]);

        $producto = Product::find($request->id_producto);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $detalleCarrito = DetalleCarrito::firstOrCreate([
            'id_carrito' => $carrito->id,
            'id_producto' => $producto->id
        ], [
            'cantidad' => 0,
            'precio' => $producto->precioVentaProd
        ]);

        $detalleCarrito->cantidad += $request->cantidad;
        $detalleCarrito->save();

        return response()->json(['message' => 'Producto agregado al carrito', 'carrito' => $carrito]);

    }
    public function getCart()
    {
        $user = auth()->user();
        $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();
    
        if (!$carrito) {
            return response()->json([], 200); 
        }
    
        $totalCantidad = $carrito->detalles->sum('cantidad');
        $totalMonto = $carrito->detalles->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->precio;
        });
    
        return response()->json([
            'carrito' => $carrito,
            'totalCantidad' => $totalCantidad,
            'totalMonto' => $totalMonto
        ]);
       
    }
    public function disminuirCantidad(Request $request)
    {
        $user = auth()->user();
        $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();
    
        if (!$carrito) {
            return response()->json(['message' => 'Carrito Vacio'], 404);
        }
    
        $detalle = DetalleCarrito::where([
            ['id_carrito', $carrito->id],
            ['id_producto', $request->producto_id]
        ])->first();
    
        if (!$detalle) {
            return response()->json(['message' => 'Producto no encontrado en el Carrito'], 404);
        }
    
        $detalle->cantidad -= 1; 
    
        if ($detalle->cantidad <= 0) {
            $detalle->delete(); 
        } else {
            $detalle->save();
        }
    
        $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();
    
       
        $totalCantidad = $carrito->detalles->sum('cantidad');
        $totalMonto = $carrito->detalles->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->precio;
        });
    
        return response()->json([
            'carrito' => $carrito,
            'totalCantidad' => $totalCantidad,
            'totalMonto' => $totalMonto
        ]);

    }
    public function incrementarCantidad(Request $request)
    {
        $user = auth()->user();
    $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();

    if (!$carrito) {
        return response()->json(['message' => 'Carrito Vacio'], 404);
    }

    $detalle = DetalleCarrito::where([
        ['id_carrito', $carrito->id],
        ['id_producto', $request->producto_id]
    ])->first();

    if (!$detalle) {
        return response()->json(['message' => 'Producto no encontrado en el Carrito'], 404);
    }

    $detalle->cantidad += 1; 
    $detalle->save();

   
    $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();
    
   
    $totalCantidad = $carrito->detalles->sum('cantidad');
    $totalMonto = $carrito->detalles->sum(function ($detalle) {
        return $detalle->cantidad * $detalle->precio;
    });

    return response()->json([
        'carrito' => $carrito,
        'totalCantidad' => $totalCantidad,
        'totalMonto' => $totalMonto
    ]);

    }
    public function clearCart()
    {
        $user = auth()->user();
    $carrito = Carrito::where('id_personal', $user->id)->first();

    if (!$carrito) { 
        return response()->json(['message' => 'Carrito Vacio'], 404);
    }
    
    $carrito->detalles()->delete();
    
    return response()->json([
        'message' => 'Carrito Limpiado',
        'carrito' => [
            'detalles' => []
        ],
        'totalCantidad' => 0,
        'totalMonto' => 0
    ]);
    }
    public function removerProducto(Request $request){
        $user = auth()->user();
        $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();
    
        if (!$carrito) {
            return response()->json(['message' => 'Carrito Vacio'], 404);
        }
    
        $detalle = DetalleCarrito::where([
            ['id_carrito', $carrito->id],
            ['id_producto', $request->producto_id]
        ])->first();
    
        if (!$detalle) {
            return response()->json(['message' => 'Producto no encontrado en el Carrito'], 404);
        }
    
        $detalle->delete();
    
       
        $carrito = Carrito::with('detalles.producto')->where('id_personal', $user->id)->first();
    
       
        $totalCantidad = $carrito->detalles->sum('cantidad');
        $totalMonto = $carrito->detalles->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->precio;
        });
    
        return response()->json([
            'carrito' => $carrito,
            'totalCantidad' => $totalCantidad,
            'totalMonto' => $totalMonto
        ]);
    }
}
;
