<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        $playlists = Playlist::where('user_id', $request->user()->id)
            ->latest('updated_at')
            ->get();

        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:Filme,Série',
            'trailer' => 'required|mimes:mp4,mov,ogg,qt|max:102400'
        ]);

        $itemExistente = Playlist::where('user_id', $request->user()->id)
            ->where('nome', $request->nome)
            ->exists();

        if ($itemExistente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Este filme ou série já está na sua lista!');
        }

        $dados = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'user_id' => $request->user()->id
        ];

        if ($request->hasFile('trailer') && $request->file('trailer')->isValid()) {
            $nomeVideo = time() . '.' . $request->file('trailer')->extension();
            $request->file('trailer')->move(
                public_path('trailers'),
                $nomeVideo
            );
            $dados['trailer'] = 'trailers/' . $nomeVideo;
        }

        Playlist::create($dados);

        return redirect()->route('playlists.index')->with('success', 'Item adicionado à playlist com sucesso!');
    }

    public function edit(Request $request, $id)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)->findOrFail($id);
        return view('playlists.edit', compact('playlist'));
    }

    public function update(Request $request, $id)
    {
        set_time_limit(300);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:Filme,Série',
            'trailer' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400'
        ]);

        $playlist = Playlist::where('user_id', $request->user()->id)->findOrFail($id);

        $itemExistente = Playlist::where('user_id', $request->user()->id)
            ->where('nome', $request->nome)
            ->where('id', '!=', $id)
            ->exists();

        if ($itemExistente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Você já tem outro item com esse mesmo nome na lista!');
        }
        
        $dados = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo
        ];

        if ($request->hasFile('trailer') && $request->file('trailer')->isValid()) {
            if ($playlist->trailer && file_exists(public_path($playlist->trailer))) {
                unlink(public_path($playlist->trailer));
            }

            $nomeVideo = time() . '.' . $request->trailer->extension();
            $request->trailer->move(public_path('trailers'), $nomeVideo);
            $dados['trailer'] = 'trailers/' . $nomeVideo;
        }

        $playlist->update($dados);

        return redirect()->route('playlists.index')->with('success', 'Informações atualizadas com sucesso!');
    }

    public function destroy(Request $request, $id)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)->findOrFail($id);
        
        if ($playlist->trailer && file_exists(public_path($playlist->trailer))) {
            unlink(public_path($playlist->trailer));
        }

        $playlist->delete();

        return redirect()->route('playlists.index')->with('success', 'Item removido da playlist com sucesso!');
    }
}