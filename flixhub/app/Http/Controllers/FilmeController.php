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
        // Trava a validação em no máximo 5 no servidor também
        $request->validate([
            'titulo' => 'required|string|max:255',
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
            'descricao' => $request->descricao,
            'nota' => number_format($request->nota, 1, '.', ''), // CORREÇÃO: Força o "2.0" para o banco não bugar
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

        // Trava a validação em no máximo 5 aqui também
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $dados = [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'nota' => number_format($request->nota, 1, '.', '') // CORREÇÃO: Força o "2.0" para o banco não bugar
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

        // Apaga a foto antiga do storage para não acumular lixo
        if ($filme->imagem && Storage::disk('public')->exists($filme->imagem)) {
            Storage::disk('public')->delete($filme->imagem);
        }

        $filme->delete();

        return redirect('/filmes');
    }
}