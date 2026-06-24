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
    public function index(Request $request)
    {
        $termo = $request->input('query');
        $resultados = collect();
        $userId = $request->user()->id;

        if ($termo) {
            $filmes = Filme::where('user_id', $userId)
                ->where(function ($query) use ($termo) {
                    $query->where('titulo', 'LIKE', "%{$termo}%")
                          ->orWhere('genero', 'LIKE', "%{$termo}%");
                })
                ->get()
                ->map(function ($item) use ($userId) {
                    $item->tipo = 'Filme';
                    $item->favorito = Favorito::where('user_id', $userId)
                        ->where('favoritavel_id', $item->id)
                        ->where('favoritavel_type', Filme::class)
                        ->exists();

                    $playlist = Playlist::where('user_id', $userId)->where('nome', $item->titulo)->first();
                    $item->trailer = $playlist ? $playlist->trailer : null;

                    return $item;
                });

            $series = Serie::where('user_id', $userId)
                ->where(function ($query) use ($termo) {
                    $query->where('titulo', 'LIKE', "%{$termo}%")
                          ->orWhere('genero', 'LIKE', "%{$termo}%");
                })
                ->get()
                ->map(function ($item) use ($userId) {
                    $item->tipo = 'Série';
                    $item->favorito = Favorito::where('user_id', $userId)
                        ->where('favoritavel_id', $item->id)
                        ->where('favoritavel_type', Serie::class)
                        ->exists();

                    $playlist = Playlist::where('user_id', $userId)->where('nome', $item->titulo)->first();
                    $item->trailer = $playlist ? $playlist->trailer : null;

                    return $item;
                });

            $resultados = $filmes->concat($series);
        }

        $minhaLista = Busca::where('user_id', $userId)
            ->latest('updated_at')
            ->get()
            ->map(function ($item) use ($userId) {
                $playlist = Playlist::where('user_id', $userId)->where('nome', $item->titulo_obra)->first();
                $item->trailer = $playlist ? $playlist->trailer : null;
                return $item;
            });

        return view('busca.index', compact('resultados', 'termo', 'minhaLista'));
    }

    public function create(Request $request)
    {
        $titulo = $request->query('titulo');
        $userId = $request->user()->id;
        
        $obra = Filme::where('user_id', $userId)->where('titulo', $titulo)->first();

        if (!$obra) {
            $obra = Serie::where('user_id', $userId)->where('titulo', $titulo)->first();
            if ($obra) {
                $obra->tipo = 'Série';
            }
        } else {
            $obra->tipo = 'Filme';
        }

        $playlist = null;
        if ($obra) {
            $playlist = Playlist::where('user_id', $userId)->where('nome', $obra->titulo)->first();
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
        
        $obra = Filme::where('user_id', $userId)->where('titulo', $request->input('titulo_obra'))->first();
        $tipo = 'Filme';
        $isFavorito = false;

        if (!$obra) {
            $obra = Serie::where('user_id', $userId)->where('titulo', $request->input('titulo_obra'))->first();
            $tipo = 'Série';
            
            if ($obra) {
                $isFavorito = Favorito::where('user_id', $userId)
                    ->where('favoritavel_id', $obra->id)
                    ->where('favoritavel_type', Serie::class)
                    ->exists();
            }
        } else {
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
            'favoritado'  => $isFavorito ? 1 : 0,
            'favorito'    => $isFavorito ? 1 : 0,
            'imagem'      => $obra ? $obra->imagem : null,
            'comentario'  => $request->input('comentario'),
            'status'      => $request->input('status'),
        ]);

        return redirect()->route('busca.index')->with('success', 'Item adicionado à sua lista com sucesso!');
    }

    public function show(Busca $busca) {}

    public function edit(Request $request, $id)
    {
        $userId = $request->user()->id;
        $busca = Busca::where('user_id', $userId)->findOrFail($id);
        $obra = Filme::where('user_id', $userId)->where('titulo', $busca->titulo_obra)->first();

        if (!$obra) {
            $obra = Serie::where('user_id', $userId)->where('titulo', $busca->titulo_obra)->first();
            if ($obra) {
                $obra->tipo = 'Série';
            }
        } else {
            $obra->tipo = 'Filme';
        }

        $playlist = null;
        if ($obra) {
            $playlist = Playlist::where('user_id', $userId)->where('nome', $obra->titulo)->first();
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

        return redirect()->route('busca.index')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy(Request $request, $id)
    {
        $busca = Busca::where('user_id', $request->user()->id)->findOrFail($id);
        $busca->delete();

        return redirect()->route('busca.index')->with('success', 'Item removido da sua lista!');
    }
}