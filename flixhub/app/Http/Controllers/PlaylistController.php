<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    // [R]ead - Lista as playlists do usuário logado
    public function index(Request $request)
    {
        $playlists = Playlist::where('user_id', $request->user()->id)->get();
        return view('playlists.index', compact('playlists'));
    }

    // Abre a tela de criação
    public function create()
    {
        return view('playlists.create');
    }

    // [C]reate - Salva a playlist no banco com o vídeo e tipo
   public function store(Request $request)
{
    set_time_limit(300);

    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'tipo' => 'required|in:Filme,Série',
        'trailer' => 'required|mimes:mp4,mov,ogg,qt|max:102400'
    ]);

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

    return redirect()->route('playlists.index');
}

    // Abre a tela de edição, protegendo contra outros usuários
    public function edit(Request $request, $id)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)->findOrFail($id);
        return view('playlists.edit', compact('playlist'));
    }

    // [U]pdate - Salva as alterações da playlist e atualiza o vídeo se enviado
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
        
        $dados = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo
        ];

        // Se o usuário subiu um novo vídeo, substitui o antigo
        if ($request->hasFile('trailer') && $request->file('trailer')->isValid()) {
            // Deleta o arquivo de vídeo anterior do armazenamento para não acumular lixo
            if ($playlist->trailer && file_exists(public_path($playlist->trailer))) {
                unlink(public_path($playlist->trailer));
            }

            $nomeVideo = time() . '.' . $request->trailer->extension();
            $request->trailer->move(public_path('trailers'), $nomeVideo);
            $dados['trailer'] = 'trailers/' . $nomeVideo;
        }

        $playlist->update($dados);

        return redirect()->route('playlists.index');
    }

    // [D]elete - Exclui a playlist e o arquivo do vídeo físico
    public function destroy(Request $request, $id)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)->findOrFail($id);
        
        // Remove o vídeo do sistema antes de apagar o registro
        if ($playlist->trailer && file_exists(public_path($playlist->trailer))) {
            unlink(public_path($playlist->trailer));
        }

        $playlist->delete();

        return redirect()->route('playlists.index');
    }
}