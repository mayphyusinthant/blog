<?php

namespace App\Http\Controllers;
use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
	public function __construct(){
		$this->middleware('auth')->except(['index', 'detail']);
	}

    public function index(){
		//$data = Article::all();
		//Use Pagination - only 5 contents in one pagination
		//using 'latest()' means return data from the latest one
		$data = Article::latest()-> paginate(5);
		return view('articles.index' , [
			'articles' => $data
		]);
		//return view('articles/index');	
		//return "Controller - Article List";
	}

	public function detail($id) {
		//return "Controller - Article Detail - $id";
		$data = Article::find($id);
		return view('articles.detail', [
			'article' => $data
		]);
	}


	public function add(){
		$data = [
			["id" => 1, "name" =>  "New"],
			["id" => 2, "name" => "Tech"],
		];
		return view('articles.add', [
			'categories' => $data
		]);
	}

	public function create(){
		//check validation to avoid integrity violation error occurs
		$validator = validator(request() -> all(), [
			'title' => 'required',
			'body' => 'required',
			'category_id' => 'required',
		]);
		if($validator->fails()){
			return back()->withErrors($validator);
		}
		$article = new Article();
		$article->title = request()->title;
		$article->body = request()->body;
		$article->category_id = request()->category_id;
		$article->save();
		
		return redirect('/articles');
	}
 	public function edit($id)
    {
		$data = [
			["id" => 1, "name" =>  "New"],
			["id" => 2, "name" => "Tech"],
		];
        $article = Article::find($id);
        return view('articles.edit', [
			'categories' => $data
		]);
    }
	public function update(Request $request, $id){
		//check validation to avoid integrity violation error occurs
		$validator = validator(request() -> all(), [
			'title' => 'required',
			'body' => 'required',
			'category_id' => 'required',
		]);
		if($validator->fails()){
			return back()->withErrors($validator);
		}
		$article = Article::find($id);
		$article->title = request()->get('title');
		$article->body = request()->get('body');
		$article->category_id = request()->get('category_id');
		$article->save();
		
		return view('articles.detail', [
			'article' => $article
		])->with('success', 'Article Updated.');
	}

	public function delete($id){
		$article = Article::find($id);
		$article->delete();
		return redirect('/articles')->with('info', 'Article deleted.');
	}
}
