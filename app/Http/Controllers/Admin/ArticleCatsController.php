<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\BackController;

use Illuminate\Http\Request;

use App\Models\ArticleCat;

use Redirect, Input, Auth;

class ArticleCatsController extends BackController {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $articleCats = ArticleCat::paginate(10);
        return view('admin.article_cats.index')->with('articleCats',$articleCats);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        //栏目select数据
        //dump(ArticleCat::getChilds(0));
        $cats = ArticleCat::getSelectCats();
        //$cats = ArticleCat::all();
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
			//'cat_brief' => 'required',
		]);

		$articleCat= new ArticleCat;
		$articleCat->cat_name = $request->input('cat_name');
        //$post->slug = Str::slug(Input::get('title'));
		$articleCat->parent_id = Input::get('parent_id');
		$articleCat->cat_brief= Input::get('cat_brief');

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
            $articleCat->image = $folderName.'/'.$safeName;
        }

		if ($articleCat->save()) {
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
        return view('admin.article_cats.show')->with('articleCat', ArticleCat::find($id))->with('articls', ArticleCat::paginate(10)); 
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $cats = ArticleCat::getSelectCats();
		return view('admin.article_cats.edit')->with('articleCat',ArticleCat::find($id))->with('articleCats', $cats);
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
			'cat_name' => 'required|max:255',
			//'cat_brief' => 'required',
		]);
		
		$articleCat = ArticleCat::find($id);
		$articleCat->cat_name = Input::get('cat_name');
		$articleCat->parent_id = Input::get('parent_id');
		$articleCat->cat_brief= Input::get('cat_brief');
        if ($file = Input::file('image')) {
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions))
            {
                return ['error' => '只支持上传png, jpg,  gif格式'];
            }
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = 'uploads/images/' . date("Ym", time()) .'/'.date("d", time());
            $destinationPath = public_path() . '/' . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);
            $articleCat->image = $folderName.'/'.$safeName;
        }
        
        if ($articleCat->save()) {
			return Redirect::to('admin/article/cats');
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
        //删除所有文章,包括子栏目文章
        //删除所有子栏目
        $cat = ArticleCat::find($id);
        $cat->delete();

		return Redirect::to('admin/article/cats');
	}

}
