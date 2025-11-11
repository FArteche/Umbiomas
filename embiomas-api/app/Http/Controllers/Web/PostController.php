<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Bioma;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function indexBiomas()
    {
        $biomas = Bioma::withCount(['posts', 'pendingPosts'])
            ->orderBy('nome_bioma')
            ->get();

        return view('admin.post.index_biomas', compact('biomas'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('postador');
        return view('admin.post.show', compact('post'));
    }

    public function approve(Post $post)
    {
        $post->update(['aprovado_post' => true]);
        $post->historico()->create([
            'user_id' => Auth::id(),
            'nome_objeto' => $post->titulo_post,
            'tipo_alteracao' => 'edicao',
            'detalhes_alteracao' => 'Post Aprovado'
        ]);
        return redirect()->route('post.show', $post)->with('success', 'Post aprovado com sucesso !');
    }

    public function reject(Post $post)
    {
        $post->update(['aprovado_post' => false]);
        $post->historico()->create([
            'user_id' => Auth::id(),
            'nome_objeto' => $post->titulo_post,
            'tipo_alteracao' => 'edicao',
            'detalhes_alteracao' => 'Post Reprovado'
        ]);
        return redirect()->route('post.show', $post)->with('success', 'Post rejeitado com sucesso !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->historico()->create([
            'user_id' => Auth::id(),
            'nome_objeto' => $post->titulo_post,
            'tipo_alteracao' => 'exclusao',
            'detalhes_alteracao' => 'Post excluído: ' . $post->titulo_post
        ]);

        $biomaId = $post->bioma_id;

        $post->delete();

        return redirect()->route('biomas.managePost', $biomaId)->with('success', 'Post excluído com sucesso');
    }
}
