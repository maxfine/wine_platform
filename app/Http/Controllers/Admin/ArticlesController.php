<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\BackController;

use Illuminate\Http\Request;
use App\Models\ArticleCat;
use App\Models\Article;
use Redirect, Input, Auth;

class ArticlesController extends BackController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('admin.articles.index')->with('articles',Article::paginate(10));
	}

    public function getList($catId)
    {
        $cat = ArticleCat::find($catId);
        //dump(ArticleCat::with('articles')->get());
        $articleCat = ArticleCat::find($catId);
        $articles = Article::whereIn('cat_id', $articleCat->allCatIds())->paginate(10);
        return view('admin.articles.list')->with('articles', $articles);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $articleCats = ArticleCat::getSelectCats();
		return view('admin.articles.create')->with('articleCats', $articleCats);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
    {
        $this->validate($request, [
			'title' => 'required|unique:articles|max:255',
		]);

		$article= new Article;
		$article->title = $request->input('title');
        //$post->slug = Str::slug(Input::get('title'));
		$article->cat_id = Input::get('cat_id');
		$article->content = Input::get('content');
		$article->user_id = Auth::user()->id;

        if ($file = Input::file('thumb')) {
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions))
            {
                return ['error' => 'You may only upload png, jpg or gif.'];
            }
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = 'uploads/images/' . date("Ym", time()) .'/'.date("d", time());
            $destinationPath = public_path() . '/' . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);
            $article->thumb = $folderName.'/'.$safeName;
        }

		if ($article->save()) {
			return Redirect::to('admin/articles');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        $article = Article::find($id);
        return view('admin.articles.show')->with('article', $article)->with('comments', $article->comments()); 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $article = Article::find($id);
        //栏目下拉框
        $articleCats = ArticleCat::getSelectCats(); 
        return view('admin.articles.edit')->with('article', $article)->with('articleCats',$articleCats);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'title' => 'required|max:255',
		]);

		$article= Article::find($id);
		$article->title = $request->input('title');
        //$post->slug = Str::slug(Input::get('title'));
		$article->cat_id = Input::get('cat_id');
		$article->content = Input::get('content');
		$article->user_id = Auth::user()->id;

        if ($file = Input::file('thumb')) {
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions))
            {
                return ['error' => 'You may only upload png, jpg or gif.'];
            }
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = 'uploads/images/' . date("Ym", time()) .'/'.date("d", time());
            $destinationPath = public_path() . '/' . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);
            $article->thumb = $folderName.'/'.$safeName;
        }

		if ($article->save()) {
			return Redirect::to('admin/articles');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
     */
    public function destroy($id)
	{
        //同时删除所有评论
        $article = Article::find($id);
        $article->delete();

		return Redirect::to('admin/articles');
	}
}
