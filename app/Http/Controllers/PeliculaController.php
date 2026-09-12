<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    // GET /api/peliculas
    public function index()
    {
        $peliculas = Pelicula::all();
        return response()->json($peliculas, 200);
    }

    // GET /api/peliculas/{id}
    public function show($id)
    {
        $pelicula = Pelicula::with('rentas.cliente')->find($id);

        if (!$pelicula) {
            return response()->json(['message' => 'Pelicula no encontrada'], 404);
        }

        return response()->json($pelicula, 200);
    }

    // POST /api/peliculas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Titulo'    => 'required|string|max:50',
            'Categoria' => 'required|string|max:50',
            'Precio'    => 'required|numeric',
            'Duracion'  => 'required|integer',
        ]);

        $pelicula = Pelicula::create($validated);

        return response()->json($pelicula, 201);
    }

    // PUT/PATCH /api/peliculas/{id}
    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::find($id);

        if (!$pelicula) {
            return response()->json(['message' => 'Pelicula no encontrada'], 404);
        }

        $validated = $request->validate([
            'Titulo'    => 'sometimes|string|max:50',
            'Categoria' => 'sometimes|string|max:50',
            'Precio'    => 'sometimes|numeric',
            'Duracion'  => 'sometimes|integer',
        ]);

        $pelicula->update($validated);

        return response()->json($pelicula, 200);
    }

    // DELETE /api/peliculas/{id}
    public function destroy($id)
    {
        $pelicula = Pelicula::find($id);

        if (!$pelicula) {
            return response()->json(['message' => 'Pelicula no encontrada'], 404);
        }

        // Evita borrar si tiene rentas asociadas (integridad referencial)
        if ($pelicula->rentas()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar: la pelicula tiene rentas asociadas'
            ], 409);
        }

        $pelicula->delete();

        return response()->json(['message' => 'Pelicula eliminada correctamente'], 200);
    }
}