<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class productosController extends Controller
{
    
    public function index()
    {
        $productos = Product::all();
        
        $productosFormateados = $productos->map(function($producto){
            return [
                'id' => $producto->id,
                'nombreProd'=>$producto->nombreProd,
                'marcaProd'=>$producto->marcaProd,
                'presentacionProd'=>$producto->presentacionProd,
                'precioCompraProd' => (float)$producto->precioCompraProd,
                'precioVentaProd' => (float)$producto->precioVentaProd,
                'stockProd' => (int)$producto->stockProd,
                'imagenProd'=> $producto->imagenProd
            ];
        });


        if($productosFormateados->isEmpty()){
            return response()->json(['message' => 'No hay productos'], 404);
        }

        return response()->json($productosFormateados);
        
    }

    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombreProd' => 'required|string|max:255',
            'marcaProd' => 'required|string|max:255',
            'presentacionProd' => 'required|string|max:255',
            'precioCompraProd' => 'required|numeric',
            'precioVentaProd' => 'required|numeric',
            'stockProd' => 'required|numeric',
            'imagenProd' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $producto = new Product();
        $producto->nombreProd = $validatedData['nombreProd'];
        $producto->marcaProd = $validatedData['marcaProd'];
        $producto->presentacionProd = $validatedData['presentacionProd'];
        $producto->precioCompraProd = $validatedData['precioCompraProd'];
        $producto->precioVentaProd = $validatedData['precioVentaProd'];
        $producto->stockProd = $validatedData['stockProd'];

        if ($request->hasFile('imagenProd')) {
            $image = $request->file('imagenProd');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); 
            $producto->imagenProd = 'images/'.$imageName; 
        }
        
        $producto->save(); 
        return response()->json(['message' =>'Producto Creado Correctamente','Producto'=> $producto]);
    }

    
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
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombreProd' => 'required|string|max:255',
            'marcaProd' => 'required|string|max:255',
            'presentacionProd' => 'required|string|max:255',
            'precioCompraProd' => 'required|numeric',
            'precioVentaProd' => 'required|numeric',
            'stockProd' => 'required|numeric',
            'imagenProd' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $producto = Product::findOrFail($id);
        $producto->nombreProd = $validatedData['nombreProd'];
        $producto->marcaProd = $validatedData['marcaProd'];
        $producto->presentacionProd = $validatedData['presentacionProd'];
        $producto->precioCompraProd = $validatedData['precioCompraProd'];
        $producto->precioVentaProd = $validatedData['precioVentaProd'];
        $producto->stockProd = $validatedData['stockProd'];
    
        if ($request->hasFile('imagenProd')) {
          
            if ($producto->imagenProd && file_exists(public_path($producto->imagenProd))) {
                unlink(public_path($producto->imagenProd));
            }
    
            $image = $request->file('imagenProd');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); 
            $producto->imagenProd = 'images/'.$imageName; 
        }
        
        $producto->save(); 
    
        return response()->json(['message' => 'Producto Actualizado Correctamente', 'Producto' => $producto]);
    }

    public function destroy($id)
    {
        $producto = Product::find($id);

    if (!$producto) {
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    // Si el producto tiene una imagen asociada, la eliminamos
    if ($producto->imagenProd && file_exists(public_path($producto->imagenProd))) {
        unlink(public_path($producto->imagenProd));
    }

    $producto->delete();

    return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
