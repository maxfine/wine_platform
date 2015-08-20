<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\BackController;

use Illuminate\Http\Request;

use App\Models\Category;

use Redirect, Input, Auth;

class GoodsCatsController extends BackController {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $cats = Category::paginate(10);
        return view('admin.goods_cats.index')->with('cats',$cats);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        //栏目select数据
        $cats = Category::getSelectCats();
		return view('admin.goods_cats.create')->with('cats',$cats);
	}
    
    
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
   		$this->validate($request, [
			'cat_name' => 'required|unique:categories|max:255',
			//'cat_brief' => 'required',
		]);

		$cat= new Category;
		$cat->cat_name = $request->input('cat_name');
        //$post->slug = Str::slug(Input::get('title'));
		$cat->parent_id = Input::get('parent_id');
		$cat->cat_brief= Input::get('cat_brief');

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
            $cat->image = $folderName.'/'.$safeName;
        }

		if ($cat->save()) {
			return Redirect::to('admin/goods/cats');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
		}

	}

    /**
     * 查看
     */
    public function show($id)
    {
        return view('admin.goods_cats.show')->with('cat', Category::find($id)); 
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $cats = Category::getSelectCats();
		return view('admin.goods_cats.edit')->with('cat',Category::find($id))->with('cats', $cats);
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
		
		$cat = Category::find($id);
		$cat->cat_name = Input::get('cat_name');
		$cat->parent_id = Input::get('parent_id');
		$cat->cat_brief= Input::get('cat_brief');
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
            $cat->image = $folderName.'/'.$safeName;
        }
        
        if ($cat->save()) {
			return Redirect::to('admin/goods/cats');
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
        $cat = Category::find($id);
        $cat->delete();

		return Redirect::to('admin/goods/cats');
	}

}
