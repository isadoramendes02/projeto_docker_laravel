<?php

namespace App\Http\Controllers;

use App\Models\Busca;
use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilmeController extends Controller
{
    public function index()
    {
        $filmes = Filme::where('user_id', Auth::id())->latest()->get();
        return view('filmes.index', compact('filmes'));
    }

    public function create()
    {
        return view('filmes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'   => 'required|string|max:255',
            'genero'   => 'required|string|max:100',
            'descricao'=> 'required',
            'nota'     => 'required|numeric|min:0|max:5',
            'imagem'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $existe = Filme::where('user_id', Auth::id())
            ->where('titulo', trim($request->titulo))
            ->exists();

        if ($existe) {
            return redirect('/filmes')->with('error', 'Este filme já está cadastrado na sua lista!');
        }

        $caminhoImagem = null;
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                $caminhoImagem = $request->file('imagem')->store('filmes', 'fotos_publicas');
            } catch (\Exception $e) {
                $caminhoImagem = null;
            }
        }

        Filme::create([
            'titulo'    => trim($request->titulo),
            'genero'    => $request->genero,
            'descricao' => $request->descricao,
            'nota'      => $request->nota,
            'imagem'    => $caminhoImagem,
            'user_id'   => Auth::id(),
        ]);

        return redirect('/filmes')->with('success', 'Filme criado com sucesso!');
    }

    public function show($id)
    {
        $filme = Filme::findOrFail($id);
        return view('filmes.show', compact('filme'));
    }

    public function edit($id)
    {
        $filme = Filme::findOrFail($id);
        return view('filmes.edit', compact('filme'));
    }

    public function update(Request $request, $id)
    {
        $filme = Filme::findOrFail($id);

        $request->validate([
            'titulo'    => 'required|string|max:255',
            'genero'    => 'required|string|max:100',
            'descricao' => 'required',
            'nota'      => 'required|numeric|min:0|max:5',
            'imagem'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $existe = Filme::where('user_id', Auth::id())
            ->where('titulo', trim($request->titulo))
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return redirect('/filmes')->with('error', 'Você já possui outro filme cadastrado com este mesmo título!');
        }

        $dados = [
            'titulo'    => trim($request->titulo),
            'genero'    => $request->genero,
            'descricao' => $request->descricao,
            'nota'      => $request->nota
        ];

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                if ($filme->imagem && Storage::disk('fotos_publicas')->exists($filme->imagem)) {
                    Storage::disk('fotos_publicas')->delete($filme->imagem);
                }
                $dados['imagem'] = $request->file('imagem')->store('filmes', 'fotos_publicas');
            } catch (\Exception $e) {
                $dados['imagem'] = $filme->imagem;
            }
        }

        $filme->update($dados);

        return redirect('/filmes')->with('success', 'Filme atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $filme = Filme::findOrFail($id);

        try {
            if ($filme->imagem && Storage::disk('fotos_publicas')->exists($filme->imagem)) {
                Storage::disk('fotos_publicas')->delete($filme->imagem);
            }
        } catch (\Exception $e) {}

        // ✅ Deleta da lista de busca automaticamente
        Busca::where('user_id', $filme->user_id)
            ->where('titulo_obra', $filme->titulo)
            ->delete();

        $filme->delete();

        return redirect('/filmes')->with('success', 'Filme deletado com sucesso!');
    }
}