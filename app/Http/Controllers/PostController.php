<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    //
    public function index(){
        return Inertia::render('Posts', [
            'success' => session('success'), // Pasa el mensaje de éxito desde la sesión
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        $post->save();

        return redirect()->route('posts')->with('success', 'Post created successfully!');
    }

    public function show(){
        $post = Post::all();
        return Inertia::render('ShowPost', [
            'posts' => $post
        ]);
    }

    public function showPost($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        
        if ($comments->isEmpty()) {
            return Inertia::render('ShowPostDetail', [
                'posts' => $post,
                'comments' => [],
                'success' => session('success')
            ]);
        }
    
        return Inertia::render('ShowPostDetail', [
            'posts' => $post,
            'comments' => $comments,
            'success' => session('success')
            
        ]);
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $comment = new Comment([
            'post_id' => $request->postId,
            'content' => $request->content,
        ]); 

        $comment->save();

       return redirect()->route('posts.showPost', ['id' => $request->postId])->with('success', 'Comentario Subido correctamente!');
    }

    public function deletePost($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.show')->with('success', 'Post eliminado correctamente!');
    }

    public function deleteComment($id, Request $request){
        $comment = Comment::findOrFail($id); 
        $comment->delete(); 
        return redirect()->route('posts.showPost', ['id' => $request->postId])->with('success', 'Comentario eliminado correctamente!'); 
    }
}
