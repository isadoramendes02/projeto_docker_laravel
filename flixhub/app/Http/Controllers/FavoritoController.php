<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Exibe a listagem de favoritos (Index)
     */
    public function index()
    {
        // Puxa todos os favoritos trazendo junto os dados do Filme ou Série original
        $favoritos = Favorito::with('favoritavel')->get();
        return view('favoritos.index', compact('favoritos'));
    }

    /**
     * ATUALIZADO: Exibe a tela para criar um favorito com comentário opcional (Create)
     */
    public function create(Request $request)
    {
        // Valida se os dados necessários vieram na URL (ex: /favoritos/create?id=1&tipo=Filme)
        $request->validate([
            'id' => 'required|integer',
            'tipo' => 'required|string'
        ]);

        // Define a classe correspondente ao tipo enviado
        $model = $request->tipo === 'Filme' ? \App\Models\Filme::class : \App\Models\Serie::class;
        
        // Busca o registro original no banco para exibir o título na tela
        $item = $model::findOrFail($request->id);
        $tipo = $request->tipo;

        return view('favoritos.create', compact('item', 'tipo'));
    }

    /**
     * ATUALIZADO: Salva o novo favorito com o comentário inicial no banco (Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'tipo' => 'required|string', // 'Filme' ou 'Serie'
            'comentario' => 'nullable|string|max:1000'
        ]);

        $modelType = $request->tipo === 'Filme' ? \App\Models\Filme::class : \App\Models\Serie::class;

        // Evita duplicar o mesmo favorito caso o usuário clique duas vezes rápido
        $existe = Favorito::where('favoritavel_id', $request->id)
                          ->where('favoritavel_type', $modelType)
                          ->exists();

        if (!$existe) {
            Favorito::create([
                'favoritavel_id' => $request->id,
                'favoritavel_type' => $modelType,
                'comentario' => $request->comentario // Gravando o comentário enviado pelo formulário de criação
            ]);
        }

        // Redireciona o usuário para a listagem principal de favoritos
        return redirect('/favoritos');
    }

    /**
     * Não será necessário exibir um único favorito isolado
     */
    public function show(Favorito $favorito)
    {
        return redirect('/favoritos');
    }

    /**
     * Exibe a tela de edição do comentário do favorito (Edit)
     */
    public function edit(Favorito $favorito)
    {
        // Carrega o relacionamento polimórfico (Filme/Série) para exibir o título na tela de edição
        $favorito->load('favoritavel');
        return view('favoritos.edit', compact('favorito'));
    }

    /**
     * Atualiza o comentário do favorito no banco (Update)
     */
    public function update(Request $request, Favorito $favorito)
    {
        $request->validate([
            'comentario' => 'nullable|string|max:1000'
        ]);

        // Atualiza o comentário diretamente no objeto injetado pelo Laravel
        $favorito->update([
            'comentario' => $request->comentario
        ]);

        // Redireciona o usuário de volta para a tela principal de favoritos
        return redirect('/favoritos');
    }

    /**
     * Remove o favorito do banco de dados (Destroy)
     */
    public function destroy($id)
    {
        // Encontra o favorito pelo ID dele na tabela de favoritos e deleta
        $favorito = Favorito::findOrFail($id);
        $favorito->delete();

        return redirect()->back();
    }
}