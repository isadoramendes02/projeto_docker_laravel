<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SerieController extends Controller
{
    /**
     * Exibe a listagem de séries (Index)
     */
    public function index()
    {
        $series = Serie::where('user_id', Auth::id())->get();
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
            'genero' => 'required|string|max:100',
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $caminhoImagem = null;

        // Tenta salvar a imagem direto na pasta pública usando o disco 'fotos_publicas'
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            try {
                $caminhoImagem = $request->file('imagem')->store('series', 'fotos_publicas');
            } catch (\Exception $e) {
                $caminhoImagem = null; 
            }
        }

        // Cria o registro no banco usando a model com $fillable
        Serie::create([
            'titulo'    => $request->titulo,
            'genero'    => $request->genero, 
            'descricao' => $request->descricao, 
            'nota'      => $request->nota,
            'imagem'    => $caminhoImagem,
            'user_id' => $request->user()->id,
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
            'genero' => 'required|string|max:100',
            'descricao' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
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
                if ($serie->imagem && Storage::disk('fotos_publicas')->exists($serie->imagem)) {
                    Storage::disk('fotos_publicas')->delete($serie->imagem);
                }
                // Salva a nova imagem no disco público
                $dados['imagem'] = $request->file('imagem')->store('series', 'fotos_publicas');
            } catch (\Exception $e) {
                // Mantém a imagem antiga caso o upload falhe
                $dados['imagem'] = $serie->imagem;
            }
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

        try {
            // Remove a imagem antiga do disco correto 'fotos_publicas' antes de apagar do banco
            if ($serie->imagem && Storage::disk('fotos_publicas')->exists($serie->imagem)) {
                Storage::disk('fotos_publicas')->delete($serie->imagem);
            }
        } catch (\Exception $e) {
            // Ignora erro se não conseguir apagar o arquivo físico e prossegue deletando do banco
        }

        $serie->delete();

        return redirect('/series');
    }
}