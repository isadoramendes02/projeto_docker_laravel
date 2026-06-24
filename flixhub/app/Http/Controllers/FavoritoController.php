<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::where('user_id', Auth::id())->latest()->get();
        return view('favoritos.index', compact('favoritos'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'tipo' => 'required|string'
        ]);

        $model = $request->tipo === 'Filme' ? \App\Models\Filme::class : \App\Models\Serie::class;
        $item = $model::findOrFail($request->id);
        $tipo = $request->tipo;

        return view('favoritos.create', compact('item', 'tipo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'tipo' => 'required|string', 
            'comentario' => 'nullable|string|max:1000'
        ]);

        $modelType = $request->tipo === 'Filme' ? \App\Models\Filme::class : \App\Models\Serie::class;

        $existe = Favorito::where('user_id', Auth::id())
            ->where('favoritavel_id', $request->id)
            ->where('favoritavel_type', $modelType)
            ->exists();

        if ($existe) {
            return redirect('/favoritos')->with('error', 'Este título já está nos seus favoritos!');
        }

        Favorito::create([
            'favoritavel_id' => $request->id,
            'favoritavel_type' => $modelType,
            'comentario' => $request->comentario,
            'user_id' => Auth::id(),
        ]);

        return redirect('/favoritos')->with('success', 'Adicionado aos favoritos com sucesso!');
    }

    public function show(Favorito $favorito)
    {
        return redirect('/favoritos');
    }

    public function edit(Favorito $favorito)
    {
        $favorito->load('favoritavel');
        return view('favoritos.edit', compact('favorito'));
    }

    public function update(Request $request, Favorito $favorito)
    {
        $request->validate([
            'comentario' => 'nullable|string|max:1000'
        ]);

        $favorito->update([
            'comentario' => $request->comentario
        ]);

        return redirect('/favoritos')->with('success', 'Nota atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $favorito = Favorito::findOrFail($id);
        $favorito->delete();

        return redirect('/favoritos')->with('success', 'Removido dos favoritos com sucesso!');
    }
}