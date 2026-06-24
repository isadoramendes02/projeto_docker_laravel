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
     * Exibe a página principal com a barra de busca
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

                    $item->favorito = Favorito::where(
                        'favoritavel_id',
                        $item->id
                    )
                    ->where(
                        'favoritavel_type',
                        Filme::class
                    )
                    ->exists();

                    $playlist = Playlist::where(
                        'nome',
                        $item->titulo
                    )->first();

                    $item->trailer = $playlist
                        ? $playlist->trailer
                        : null;

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

                    $item->favorito = Favorito::where(
                        'favoritavel_id',
                        $item->id
                    )
                    ->where(
                        'favoritavel_type',
                        Serie::class
                    )
                    ->exists();

                    $playlist = Playlist::where(
                        'nome',
                        $item->titulo
                    )->first();

                    $item->trailer = $playlist
                        ? $playlist->trailer
                        : null;

                    return $item;
                });

            $resultados = $filmes->concat($series);
        }

        $minhaLista = Busca::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'busca.index',
            compact(
                'resultados',
                'termo',
                'minhaLista'
            )
        );
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

        $playlist = Playlist::where(
            'nome',
            $obra->titulo
        )->first();
    }

    return view(
        'busca.create',
        compact(
            'titulo',
            'obra',
            'playlist'
        )
    );
}
    public function show(Busca $busca)
    {
        //
    }

    public function edit(Request $request, $id)
{
    $busca = Busca::where(
        'user_id',
        $request->user()->id
    )->findOrFail($id);

    $obra = Filme::where(
        'titulo',
        $busca->titulo_obra
    )->first();

    if (!$obra) {

        $obra = Serie::where(
            'titulo',
            $busca->titulo_obra
        )->first();

        if ($obra) {
            $obra->tipo = 'Série';
        }
    } else {
        $obra->tipo = 'Filme';
    }

    $playlist = null;

    if ($obra) {
        $playlist = Playlist::where(
            'nome',
            $obra->titulo
        )->first();
    }

    return view(
        'busca.edit',
        compact(
            'busca',
            'obra',
            'playlist'
        )
    );
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string'
        ]);

        $busca = Busca::where(
            'user_id',
            $request->user()->id
        )->findOrFail($id);

        $busca->update([
            'comentario' => $request->input('comentario')
        ]);

        return redirect()
            ->route('busca.index')
            ->with(
                'sucesso',
                'Comentário atualizado com sucesso!'
            );
    }

    public function destroy(Request $request, $id)
    {
        $busca = Busca::where(
            'user_id',
            $request->user()->id
        )->findOrFail($id);

        $busca->delete();

        return redirect()
            ->route('busca.index')
            ->with(
                'sucesso',
                'Item removido da sua lista!'
            );
    }
}