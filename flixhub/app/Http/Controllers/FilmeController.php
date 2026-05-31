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
            'genero' => 'required|string|max:100',
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5', 
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240' // Limite de 10MB
        ]);

        $caminhoImagem = null;

        // Tenta salvar a imagem direto na pasta pública usando o novo disco 'fotos_publicas'
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                $caminhoImagem = $request->file('imagem')->store('filmes', 'fotos_publicas');
            } catch (\Exception $e) {
                $caminhoImagem = null; 
            }
        }

        // Salva direto deixando o Laravel e o Banco tratarem o decimal nativamente
        Filme::create([
            'titulo'    => $request->titulo,
            'genero'    => $request->genero, 
            'descricao' => $request->descricao, 
            'nota'      => $request->nota,
            'imagem'    => $caminhoImagem
        ]);

        return redirect('/filmes');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $filme = Filme::findOrFail($id);
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
            'genero' => 'required|string|max:100', 
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240' // Limite de 10MB
        ]);

        $dados = [
            'titulo' => $request->titulo,
            'genero' => $request->genero, 
            'descricao' => $request->descricao,
            'nota' => $request->nota 
        ];

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                // Remove a foto antiga usando o disco correto 'fotos_publicas'
                if ($filme->imagem && Storage::disk('fotos_publicas')->exists($filme->imagem)) {
                    Storage::disk('fotos_publicas')->delete($filme->imagem);
                }
                // Salva a foto nova no disco correto
                $dados['imagem'] = $request->file('imagem')->store('filmes', 'fotos_publicas');
            } catch (\Exception $e) {
                // Mantém a imagem antiga caso o upload falhe
                $dados['imagem'] = $filme->imagem;
            }
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

        try {
            // Remove do local físico público
            if ($filme->imagem && Storage::disk('fotos_publicas')->exists($filme->imagem)) {
                Storage::disk('fotos_publicas')->delete($filme->imagem);
            }
        } catch (\Exception $e) {
            // Ignora se der erro físico e foca em limpar o banco de dados
        }

        $filme->delete();

        return redirect('/filmes');
    }
}