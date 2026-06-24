<?php

namespace App\Http\Controllers;

use App\Models\Busca;
use App\Models\Filme;
use App\Models\Serie;
use App\Models\Favorito;
use App\Models\Playlist;
use Illuminate\Http\Request;

class BuscaController extends Controller
{
    /**
     * Exibe a página principal com a barra de busca e a lista em formato de cards com trailer
     */
    public function index(Request $request)
    {
        $termo = $request->input('query');
        $resultados = collect();
        $userId = $request->user()->id;

        if ($termo) {
            // FILMES
            $filmes = Filme::where('user_id', $userId)
                ->where(function ($query) use ($termo) {
                    $query->where('titulo', 'LIKE', "%{$termo}%")
                          ->orWhere('genero', 'LIKE', "%{$termo}%");
                })
                ->get()
                ->map(function ($item) {
                    $item->tipo = 'Filme';
                    $item->favorito = Favorito::where('favoritavel_id', $item->id)
                        ->where('favoritavel_type', Filme::class)
                        ->exists();

                    $playlist = Playlist::where('nome', $item->titulo)->first();
                    $item->trailer = $playlist ? $playlist->trailer : null;

                    return $item;
                });

            // SÉRIES
            $series = Serie::where('user_id', $userId)
                ->where(function ($query) use ($termo) {
                    $query->where('titulo', 'LIKE', "%{$termo}%")
                          ->orWhere('genero', 'LIKE', "%{$termo}%");
                })
                ->get()
                ->map(function ($item) {
                    $item->tipo = 'Série';
                    $item->favorito = Favorito::where('favoritavel_id', $item->id)
                        ->where('favoritavel_type', Serie::class)
                        ->exists();

                    $playlist = Playlist::where('nome', $item->titulo)->first();
                    $item->trailer = $playlist ? $playlist->trailer : null;

                    return $item;
                });

            $resultados = $filmes->concat($series);
        }

        // Puxa a lista salva e vincula o trailer dinamicamente pelo título da obra
        $minhaLista = Busca::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $playlist = Playlist::where('nome', $item->titulo_obra)->first();
                $item->trailer = $playlist ? $playlist->trailer : null;
                return $item;
            });

        return view('busca.index', compact('resultados', 'termo', 'minhaLista'));
    }

    public function create(Request $request)
    {
        $titulo = $request->query('titulo');
        $obra = Filme::where('titulo', $titulo)->first();

        if (!$obra) {
            $obra = Serie::where('titulo', $titulo)->first();
            if ($obra) {
                $obra->tipo = 'Série';
            }
        } else {
            $obra->tipo = 'Filme';
        }

        $playlist = null;
        if ($obra) {
            $playlist = Playlist::where('nome', $obra->titulo)->first();
        }

        return view('busca.create', compact('titulo', 'obra', 'playlist'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'titulo_obra' => 'required|string',
            'comentario'  => 'required|string',
            'status'      => 'required|string',
        ]);

        $userId = $request->user()->id;
        
        // Tenta achar a obra original em Filmes ou Séries
        $obra = Filme::where('user_id', $userId)->where('titulo', $request->input('titulo_obra'))->first();
        $tipo = 'Filme';
        $isFavorito = false;

        if (!$obra) {
            $obra = Serie::where('user_id', $userId)->where('titulo', $request->input('titulo_obra'))->first();
            $tipo = 'Série';
            
            if ($obra) {
                // ADICIONADO: Filtra também pelo user_id do usuário logado na tabela de favoritos
                $isFavorito = Favorito::where('user_id', $userId)
                    ->where('favoritavel_id', $obra->id)
                    ->where('favoritavel_type', Serie::class)
                    ->exists();
            }
        } else {
            // ADICIONADO: Filtra também pelo user_id do usuário logado na tabela de favoritos
            $isFavorito = Favorito::where('user_id', $userId)
                ->where('favoritavel_id', $obra->id)
                ->where('favoritavel_type', Filme::class)
                ->exists();
        }

        Busca::create([
            'user_id'     => $userId,
            'titulo_obra' => $request->input('titulo_obra'),
            'tipo'        => $tipo,
            'genero'      => $obra ? $obra->genero : null,
            'nota'        => $obra ? $obra->nota : null,
            'favoritado'  => $isFavorito ? 1 : 0, // Garante o salvamento correto baseado no usuário
            'favorito'    => $isFavorito ? 1 : 0, // Mantido caso sua coluna se chame apenas favorito
            'imagem'      => $obra ? $obra->imagem : null,
            'comentario'  => $request->input('comentario'),
            'status'      => $request->input('status'),
        ]);

        return redirect()->route('busca.index')->with('sucesso', 'Item adicionado à sua lista com sucesso!');
    }
    public function show(Busca $busca) {}

    public function edit(Request $request, $id)
    {
        $busca = Busca::where('user_id', $request->user()->id)->findOrFail($id);
        $obra = Filme::where('titulo', $busca->titulo_obra)->first();

        if (!$obra) {
            $obra = Serie::where('titulo', $busca->titulo_obra)->first();
            if ($obra) {
                $obra->tipo = 'Série';
            }
        } else {
            $obra->tipo = 'Filme';
        }

        $playlist = null;
        if ($obra) {
            $playlist = Playlist::where('nome', $obra->titulo)->first();
        }

        return view('busca.edit', compact('busca', 'obra', 'playlist'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string',
            'status'     => 'required|string'
        ]);

        $busca = Busca::where('user_id', $request->user()->id)->findOrFail($id);
        $busca->update([
            'comentario' => $request->input('comentario'),
            'status'     => $request->input('status')
        ]);

        return redirect()->route('busca.index')->with('sucesso', 'Registro atualizado com sucesso!');
    }

    public function destroy(Request $request, $id)
    {
        $busca = Busca::where('user_id', $request->user()->id)->findOrFail($id);
        $busca->delete();

        return redirect()->route('busca.index')->with('sucesso', 'Item removido da sua lista!');
    }
}