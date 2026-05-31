<?php

namespace App\Http\Controllers;

use App\Models\Busca;
use App\Models\Filme; 
use App\Models\Serie; 
use Illuminate\Http\Request;

class BuscaController extends Controller
{
    /**
     * Exibe a página principal com a barra de busca por título/gênero
     * e lista todos os itens adicionados à "Minha Lista" (Read).
     */
    public function index(Request $request)
    {
        $termo = $request->input('query');
        $resultados = collect();

        if ($termo) {
            // Busca de Filmes por título ou gênero
            $filmes = Filme::where('titulo', 'LIKE', "%{$termo}%")
                            ->orWhere('genero', 'LIKE', "%{$termo}%")
                            ->get()
                            ->map(function($item) { 
                                $item->tipo = 'filme'; 
                                return $item; 
                            });

            // Busca de Séries por título ou gênero
            $series = Serie::where('titulo', 'LIKE', "%{$termo}%")
                            ->orWhere('genero', 'LIKE', "%{$termo}%")
                            ->get()
                            ->map(function($item) { 
                                $item->tipo = 'serie'; 
                                return $item; 
                            });

            // Une os dois resultados em uma única coleção
            $resultados = $filmes->concat($series);
        }

        // Obtém a lista pessoal do usuário ordenada pela data de criação
        $minhaLista = Busca::all()->isEmpty() ? collect() : Busca::orderBy('created_at', 'desc')->get();

        return view('busca.index', compact('resultados', 'termo', 'minhaLista'));
    }

    /**
     * Mostra o formulário para adicionar o comentário do filme escolhido (Create).
     */
    public function create(Request $request)
    {
        // Captura o título enviado pela URL para preencher o formulário automaticamente
        $titulo = $request->query('titulo');
        
        return view('busca.create', compact('titulo'));
    }

    /**
     * Salva o filme/série junto com o comentário no banco de dados (Store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo_obra' => 'required|string',
            'comentario'  => 'required|string'
        ]);

        Busca::create([
            'titulo_obra' => $request->input('titulo_obra'),
            'comentario'  => $request->input('comentario')
        ]);

        return redirect()->route('busca.index')->with('sucesso', 'Item adicionado à sua lista!');
    }

    /**
     * Exibe um recurso específico (Opcional / Não utilizado).
     */
    public function show(Busca $busca)
    {
        //
    }

    /**
     * Mostra o formulário preenchido para editar o comentário (Edit).
     */
    public function edit($id)
    {
        // Busca o registro pelo ID direto no banco de dados para evitar falhas de injeção
        $busca = Busca::findOrFail($id); 
        
        // Retorna a view usando o padrão de pontos do Laravel (pasta busca, arquivo edit)
        return view('busca.edit', compact('busca')); 
    }

    /**
     * Atualiza o comentário modificado pelo usuário no banco de dados (Update).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string'
        ]);

        // Encontra o registro exato no banco de dados antes de atualizar
        $busca = Busca::findOrFail($id);

        $busca->update([
            'comentario' => $request->input('comentario')
        ]);

        return redirect()->route('busca.index')->with('sucesso', 'Comentário atualizado com sucesso!');
    }

    /**
     * Remove o filme e o comentário da sua lista pessoal (Delete).
     */
    public function destroy($id)
    {
        // Encontra o registro exato no banco de dados antes de deletar
        $busca = Busca::findOrFail($id);
        $busca->delete();

        return redirect()->route('busca.index')->with('sucesso', 'Item removido da sua lista!');
    }
}