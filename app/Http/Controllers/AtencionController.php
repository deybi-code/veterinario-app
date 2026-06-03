<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Veterinario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AtencionController extends Controller
{
    public function index()
    {
        // Trae las atenciones incluyendo la información de su veterinario asignado
        $atenciones = Atencion::with('veterinario')->get();
        $veterinarios = Veterinario::all();

        return Inertia::render('Atenciones/Index', [
            'atenciones' => $atenciones,
            'veterinarios' => $veterinarios
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'veterinario_id' => 'required|exists:veterinarios,id',
            'mascota' => 'required|string|max:255',
            'diagnostico' => 'required|string',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|max:2048', // Máximo 2MB
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('atenciones', 'public');
        }

        Atencion::create($validated);

        return redirect()->route('atenciones.index');
    }

public function update(Request $request, $id)
    {
        $atencion = Atencion::findOrFail($id);

        $validated = $request->validate([
            'veterinario_id' => 'required|exists:veterinarios,id',
            'mascota' => 'required|string|max:255',
            'diagnostico' => 'required|string',
            'fecha' => 'required|date',
            'imagen' => 'nullable', 
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen vieja si existe
            if ($atencion->imagen) {
                Storage::disk('public')->delete($atencion->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('atenciones', 'public');
        }

        $atencion->update($validated);

        return redirect()->route('atenciones.index');
    }

    public function destroy($id)
    {
        $atencion = Atencion::findOrFail($id);

        if ($atencion->imagen) {
            Storage::disk('public')->delete($atencion->imagen);
        }
        
        $atencion->delete();

        return redirect()->route('atenciones.index');
    }
}    