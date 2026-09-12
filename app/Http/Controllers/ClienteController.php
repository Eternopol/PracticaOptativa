<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // GET /api/clientes
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes, 200);
    }

    // GET /api/clientes/{id}
    public function show($id)
    {
        $cliente = Cliente::with('rentas.pelicula')->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    // POST /api/clientes
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nombre'    => 'required|string|max:50',
            'Apellidos' => 'required|string|max:70',
            'Edad'      => 'nullable|integer',
            'Telefono'  => 'required|string|max:10',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json($cliente, 201);
    }

    // PUT/PATCH /api/clientes/{id}
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $validated = $request->validate([
            'Nombre'    => 'sometimes|string|max:50',
            'Apellidos' => 'sometimes|string|max:70',
            'Edad'      => 'sometimes|nullable|integer',
            'Telefono'  => 'sometimes|string|max:10',
        ]);

        $cliente->update($validated);

        return response()->json($cliente, 200);
    }

    // DELETE /api/clientes/{id}
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        // Evita borrar si tiene rentas asociadas (integridad referencial)
        if ($cliente->rentas()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar: el cliente tiene rentas asociadas'
            ], 409);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}