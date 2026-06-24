<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::where('user_id', Auth::id())->latest()->get();
        return view('series.index', compact('series'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $existe = Serie::where('user_id', Auth::id())
            ->where('titulo', trim($request->titulo))
            ->exists();

        if ($existe) {
            return redirect('/series')->with('error', 'Esta série já está cadastrada na sua lista!');
        }

        $caminhoImagem = null;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                $caminhoImagem = $request->file('imagem')->store('series', 'fotos_publicas');
            } catch (\Exception $e) {
                $caminhoImagem = null; 
            }
        }

        Serie::create([
            'titulo'    => trim($request->titulo),
            'genero'    => $request->genero, 
            'descricao' => $request->descricao, 
            'nota'      => $request->nota,
            'imagem'    => $caminhoImagem,
            'user_id'   => Auth::id(),
        ]);

        return redirect('/series')->with('success', 'Série criada com sucesso!');
    }

    public function show($id)
    {
        $serie = Serie::findOrFail($id);
        return view('series.show', compact('serie'));
    }

    public function edit($id)
    {
        $serie = Serie::findOrFail($id);
        return view('series.edit', compact('serie'));
    }

    public function update(Request $request, $id)
    {
        $serie = Serie::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $existe = Serie::where('user_id', Auth::id())
            ->where('titulo', trim($request->titulo))
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return redirect('/series')->with('error', 'Você já possui outra série cadastrada com este mesmo título!');
        }

        $dados = [
            'titulo' => trim($request->titulo),
            'genero' => $request->genero,
            'descricao' => $request->descricao,
            'nota' => $request->nota
        ];

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                if ($serie->imagem && Storage::disk('fotos_publicas')->exists($serie->imagem)) {
                    Storage::disk('fotos_publicas')->delete($serie->imagem);
                }
                $dados['imagem'] = $request->file('imagem')->store('series', 'fotos_publicas');
            } catch (\Exception $e) {
                $dados['imagem'] = $serie->imagem;
            }
        }

        $serie->update($dados);

        return redirect('/series')->with('success', 'Série editada com sucesso!');
    }

    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);

        try {
            if ($serie->imagem && Storage::disk('fotos_publicas')->exists($serie->imagem)) {
                Storage::disk('fotos_publicas')->delete($serie->imagem);
            }
        } catch (\Exception $e) {
            
        }

        $serie->delete();

        return redirect('/series')->with('success', 'Série deletada com sucesso!');
    }
}