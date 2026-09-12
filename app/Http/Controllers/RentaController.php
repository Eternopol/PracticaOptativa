<?php

namespace App\Http\Controllers;

use App\Models\Renta;
use App\Models\Cliente;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class RentaController extends Controller
{
    // GET /api/rentas
    public function index()
    {
        $rentas = Renta::with(['cliente', 'pelicula'])->get();
        return response()->json($rentas, 200);
    }

    // GET /api/rentas/{id}
    public function show($id)
    {
        $renta = Renta::with(['cliente', 'pelicula'])->find($id);

        if (!$renta) {
            return response()->json(['message' => 'Renta no encontrada'], 404);
        }

        return response()->json($renta, 200);
    }

    // POST /api/rentas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Fecha_prestamo'   => 'required|date',
            'fecha_devolucion' => 'nullable|date',
            'id_cliente'       => 'required|integer',
            'id_pelicula'      => 'required|integer',
        ]);

        // Validar que las relaciones existan antes de insertar
        if (!Cliente::find($validated['id_cliente'])) {
            return response()->json(['message' => 'El cliente indicado no existe'], 422);
        }

        if (!Pelicula::find($validated['id_pelicula'])) {
            return response()->json(['message' => 'La pelicula indicada no existe'], 422);
        }

        $renta = Renta::create($validated);
        $renta->load(['cliente', 'pelicula']);

        return response()->json($renta, 201);
    }

    // PUT/PATCH /api/rentas/{id}
    public function update(Request $request, $id)
    {
        $renta = Renta::find($id);

        if (!$renta) {
            return response()->json(['message' => 'Renta no encontrada'], 404);
        }

        $validated = $request->validate([
            'Fecha_prestamo'   => 'sometimes|date',
            'fecha_devolucion' => 'sometimes|nullable|date',
            'id_cliente'       => 'sometimes|integer|exists:Clientes,id',
            'id_pelicula'      => 'sometimes|integer|exists:Peliculas,id',
        ]);

        $renta->update($validated);
        $renta->load(['cliente', 'pelicula']);

        return response()->json($renta, 200);
    }

    // DELETE /api/rentas/{id}
    public function destroy($id)
    {
        $renta = Renta::find($id);

        if (!$renta) {
            return response()->json(['message' => 'Renta no encontrada'], 404);
        }

        $renta->delete();

        return response()->json(['message' => 'Renta eliminada correctamente'], 200);
    }
}