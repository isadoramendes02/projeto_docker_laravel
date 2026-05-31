<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SerieController extends Controller
{
    /**
     * Exibe a listagem de séries (Index)
     */
    public function index()
    {
        $series = Serie::all();
        return view('series.index', compact('series'));
    }

    /**
     * Mostra o formulário de criar (Create)
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Salva uma nova série no banco (Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100', // ADICIONADO: Validação do gênero
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5', // CORREÇÃO: Ajustado de max:10 para max:5
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $caminhoImagem = null;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $caminhoImagem = $request->file('imagem')->store('series', 'public');
        }

        Serie::create([
            'titulo' => $request->titulo,
            'genero' => $request->genero, // ADICIONADO: Gravando gênero no banco
            'descricao' => $request->descricao,
            'nota' => number_format($request->nota, 1, '.', ''), // Garante o envio de "2.0" direto pro banco
            'imagem' => $caminhoImagem
        ]);

        return redirect('/series');
    }

    /**
     * Exibe os detalhes de uma série específica (Show)
     */
    public function show($id)
    {
        $serie = Serie::findOrFail($id);
        return view('series.show', compact('serie'));
    }

    /**
     * Mostra o formulário de editar (Edit)
     */
    public function edit($id)
    {
        $serie = Serie::findOrFail($id);
        return view('series.edit', compact('serie'));
    }

    /**
     * Atualiza os dados da série no banco (Update)
     */
    public function update(Request $request, $id)
    {
        $serie = Serie::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100', // ADICIONADO: Validação do gênero no update
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $dados = [
            'titulo' => $request->titulo,
            'genero' => $request->genero, // ADICIONADO: Atualizando o gênero no banco
            'descricao' => $request->descricao,
            'nota' => number_format($request->nota, 1, '.', '') // Garante o envio de "2.0" direto pro banco
        ];

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            if ($serie->imagem && Storage::disk('public')->exists($serie->imagem)) {
                Storage::disk('public')->delete($serie->imagem);
            }
            $dados['imagem'] = $request->file('imagem')->store('series', 'public');
        }

        $serie->update($dados);

        return redirect('/series');
    }

    /**
     * Remove a série do banco de dados (Destroy)
     */
    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);

        if ($serie->imagem && Storage::disk('public')->exists($serie->imagem)) {
            Storage::disk('public')->delete($serie->imagem);
        }

        $serie->delete();

        return redirect('/series');
    }
}