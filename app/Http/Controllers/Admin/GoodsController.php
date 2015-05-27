<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Goods;
use App\Models\Photo;
use Redirect, Input, Auth;
use App\Handlers\Commands\UploadHandler;

class GoodsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('admin.goods.index')->with('goods',Goods::paginate(10));
	}

    public function getList($catId)
    {
        $cat = Category::find($catId);
        $goods = Goods::whereIn('cat_id', $cat->allCatIds())->paginate(10);
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
			'goods_name' => 'required|unique:goods|max:255',
            'store_price' => 'required|numeric|min:0',
		]);

		$goods= new Goods;
		$goods->goods_name= $request->input('goods_name');
		$goods->store_price= $request->input('store_price');
        //$post->slug = Str::slug(Input::get('title'));
		$goods->cat_id = Input::get('cat_id');
		$goods->desc = Input::get('desc');
		$goods->user_id = Auth::user()->id;
		$goods->type_id= 1; //to-do
		$goods->brand_id= 1; //to-do

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
            $goods->image = $folderName.'/'.$safeName;
        }

		if ($goods->save()) {
            $thumbUrls = Input::get('thumbUrls');
            $originalUrls = Input::get('originalUrls');
            if(is_array($originalUrls)){
                foreach($originalUrls as $k=>$originalUrl){
                    $photo = new Photo();
                    $photo->goods_id = $goods->id; 
                    $photo->original_url = $originalUrls[$k];
                    $photo->thumb_url = $thumbUrls[$k];
                    $photo->save();
                }
            }
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

        $goods = Goods::find($id);
        return view('admin.goods.show')->with('goods', $goods)->with('comments', $goods->comments()); 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $goods = Goods::find($id);
        //栏目下拉框
        $cats = Category::getSelectCats(); 
        $photos = $goods->photos;
        //to-do
        return view('admin.goods.edit')->with('goods', $goods)->with('cats',$cats);
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
			'goods_name' => 'required|unique:goods|max:255',
            'store_price' => 'required|numeric|min:0',
		]);

		$goods= Goods::find($id);
		$goods->goods_name= $request->input('goods_name');
		$goods->store_price= $request->input('store_price');
        //$post->slug = Str::slug(Input::get('title'));
		$goods->cat_id = Input::get('cat_id');
		$goods->desc = Input::get('desc');
		$goods->user_id = Auth::user()->id;
		//$goods->type_id= 1; //to-do
		//$goods->brand_id= 1; //to-do

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
            $goods->image = $folderName.'/'.$safeName;
        }

		if ($goods->save()) {
            $thumbUrls = Input::get('thumbUrls');
            $originalUrls = Input::get('originalUrls');
            if(is_array($originalUrls)){
                foreach($originalUrls as $k=>$originalUrl){
                    $photo = new Photo();
                    $photo->goods_id = $goods->id; 
                    $photo->original_url = $originalUrls[$k];
                    $photo->thumb_url = $thumbUrls[$k];
                    $photo->save();
                }
            }
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
        $goods = Goods::find($id);
        $goods->delete();

		return Redirect::to('admin/goods');
	}
}
