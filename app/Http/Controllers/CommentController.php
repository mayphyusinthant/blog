<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        $comment = new Comment();
        $comment->content = request()->content;
        $comment->article_id = request()->article_id;
        $userId = Auth::id();
        $comment->user_id = $userId;
        // or we can write
        //$comment->user_id() = auth()->user()->id;
        $comment->save();

        return back();
    }

    public function delete($id){
        $comment = Comment::find($id);
        //if($comment->user_id == auth()->user()->id){
        if(Gate::allows('comment-delete', $comment)){
            $comment->delete();
            return back();
        }
        else{
            return back()->with('error', 'Unauthorize');
        }
    }
}
