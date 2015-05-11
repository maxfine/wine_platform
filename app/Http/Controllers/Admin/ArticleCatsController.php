<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\ArticleCat;

use Redirect, Input, Auth;

class ArticleCatsController extends Controller {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('admin.article_cats.index')->withPages(ArticleCat::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        //栏目select数据
        $cats = ArticleCat::getSelectCats();
		return view('admin.article_cats.create')->with('articleCats',$cats);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
   		$this->validate($request, [
			'cat_name' => 'required|unique:article_cats|max:255',
			'cat_brief' => 'required',
		]);

		$article_cat= new ArticleCat;
		$article_cat->cat_name = Input::get('cat_name');
		$article_cat->parent_id = Input::get('parent_id');
		$article_cat->cat_brief= Input::get('cat_brief');
		//$article_cat->user_id = \Auth::user()->id;//Auth::user()->id;

		if ($article_cat->save()) {
			return Redirect::to('admin/article/cats');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
		}

	}

    /**
     * 查看
     */
    public function show($id)
    {
        return view('admin.pages.show')->withPage(Page::find($id)); 
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('admin.pages.edit')->withPage(Page::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$this->validate($request, [
			'title' => 'required|unique:pages,title,'.$id.'|max:255',
			'body' => 'required',
		]);

		$page = Page::find($id);
		$page->title = Input::get('title');
		$page->body = Input::get('body');
		$page->user_id = 1;//Auth::user()->id;

		if ($page->save()) {
			return Redirect::to('admin');
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
		$page = Page::find($id);
		$page->delete();

		return Redirect::to('admin');
	}

}
