<?php

namespace App\Http\Controllers;

use App\Models\Veterinario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VeterinarioController extends Controller
{
    public function index()
    {
        $veterinarios = Veterinario::all();
        return Inertia::render('Veterinarios/Index', [
            'veterinarios' => $veterinarios
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);

        Veterinario::create($validated);

        return redirect()->route('veterinarios.index');
    }

    public function update(Request $request, Veterinario $veterinario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);

        $veterinario->update($validated);

        return redirect()->route('veterinarios.index');
    }

    public function destroy(Veterinario $veterinario)
    {
        $veterinario->delete();
        return redirect()->route('veterinarios.index');
    }
}