<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Goods;
use Redirect, Input, Auth;

class GoodsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('admin.goods.index')->with('goods',Article::paginate(10));
	}

    public function getList($catId)
    {
        $articleCat = ArticleCat::find($catId);
        $goods = Article::whereIn('cat_id', $articleCat->allCatIds())->paginate(10);
        return view('admin.goods.list')->with('goods', $goods);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $cats = Category::getSelectCats();
		return view('admin.goods.create')->with('cats', $cats);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
    {
        $this->validate($request, [
			'title' => 'required|unique:goods|max:255',
		]);

		$article= new Article;
		$article->title = $request->input('title');
        //$post->slug = Str::slug(Input::get('title'));
		$article->cat_id = Input::get('cat_id');
		$article->body = Input::get('body');
		$article->user_id = Auth::user()->id;

        if ($file = Input::file('image')) {
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
            $article->image = $folderName.'/'.$safeName;
        }

		if ($article->save()) {
			return Redirect::to('admin/goods');
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
        return view('admin.goods.show')->with('article', $article)->with('comments', $article->comments()); 
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
        return view('admin.goods.edit')->with('article', $article)->with('articleCats',$articleCats);
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
		$article->body = Input::get('body');
		$article->user_id = Auth::user()->id;

        if ($file = Input::file('image')) {
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
            $article->image = $folderName.'/'.$safeName;
        }

		if ($article->save()) {
			return Redirect::to('admin/goods');
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

		return Redirect::to('admin/goods');
	}
}
