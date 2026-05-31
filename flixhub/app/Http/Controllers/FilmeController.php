<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filmes = Filme::all();
        return view('filmes.index', compact('filmes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filmes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100', // Validando o gênero
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5', 
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $caminhoImagem = null;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $caminhoImagem = $request->file('imagem')->store('filmes', 'public');
        }

        Filme::create([
            'titulo' => $request->titulo,
            'genero' => $request->genero, // CORREÇÃO: Salvando o gênero no banco
            'descricao' => $request->descricao,
            'nota' => number_format($request->nota, 1, '.', ''), 
            'imagem' => $caminhoImagem
        ]);

        return redirect('/filmes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Filme $filme)
    {
        return view('filmes.show', compact('filme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $filme = Filme::findOrFail($id);
        return view('filmes.edit', compact('filme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $filme = Filme::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100', // Validando no update tbm
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $dados = [
            'titulo' => $request->titulo,
            'genero' => $request->genero, // CORREÇÃO: Atualizando o gênero no banco
            'descricao' => $request->descricao,
            'nota' => number_format($request->nota, 1, '.', '') 
        ];

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            if ($filme->imagem && Storage::disk('public')->exists($filme->imagem)) {
                Storage::disk('public')->delete($filme->imagem);
            }
            $dados['imagem'] = $request->file('imagem')->store('filmes', 'public');
        }

        $filme->update($dados);

        return redirect('/filmes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $filme = Filme::findOrFail($id);

        if ($filme->imagem && Storage::disk('public')->exists($filme->imagem)) {
            Storage::disk('public')->delete($filme->imagem);
        }

        $filme->delete();

        return redirect('/filmes');
    }
}