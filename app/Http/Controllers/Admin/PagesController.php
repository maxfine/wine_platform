<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\BackController;

use Illuminate\Http\Request;

use App\Models\Page;

use Redirect, Input, Auth, BackNav, Navigation, URL;

class PagesController extends BackController {

    public function __construct(){
        parent::__construct();

        //导航
        //@todo
        //BackNav::addToMain(['title' => 'admin', 'slug' => 'admin'], 'default', false);
        //BackNav::addToMain(['title' => 'pages', 'slug' => 'pages'], 'default', false);
    }
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('admin.pages.index')->withPages(Page::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.pages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
   		$this->validate($request, [
			'title' => 'required|unique:pages|max:255',
			'content' => 'required',
		]);


		$page = new Page;
		$page->title = e(Input::get('title'));
		$page->thumb = Input::get('thumb')?e(Input::get('thumb')):'';
		$page->content = e(Input::get('content'));
		$page->user_id = Auth::user()->id;

		if ($page->save()) {
			return Redirect::to('admin');
		} else {
			return Redirect::back()->withInput($request->input())->withErrors('保存失败！');
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
		return view('admin.pages.edit')->withData(Page::findOrFail($id));
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
			'content' => 'required',
		]);

		$page = Page::find($id);
		$page->title = e(Input::get('title'));
        $page->thumb = Input::get('thumb')?e(Input::get('thumb')):'';
		$page->content = e(Input::get('content'));
		$page->user_id = Auth::user()->id;

		if ($page->save()) {
			return Redirect::to('admin/pages');
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
