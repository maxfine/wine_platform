<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\GoodsType;
use App\Models\Goods;
use App\Models\Photo;
use App\Models\GoodsAttr;
use Redirect, Input, Auth;
use App\Handlers\Commands\UploadHandler;
use Illuminate\Support\Facades\DB;

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

    /**
     * -------------------------------------------------------------------
     * 商品列表
     * -------------------------------------------------------------------
     */
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
        $types = GoodsType::all(); //获取所有types
		return view('admin.goods.create')->with('cats', $cats)->with('types', $types);
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
		$goods->type_id= Input::get('type_id'); //to-do
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

        //开始事务
        DB::beginTransaction();
        try{
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

                //商品关联属性
                $attrIdList = Input::get('attr_id_list');
                $attrValueList = Input::get('attr_value_list');
                $attrPriceList = Input::get('attr_price_list');
                if(is_array($attrIdList)){
                    $attrs = array_map(null, $attrIdList, $attrValueList, $attrPriceList);
                    foreach($attrs as $_v){
                        $attr = new GoodsAttr;
                        $attr->goods_id = $goods->id;
                        $attr->attr_id = $_v[0];
                        $attr->attr_value = $_v[1];
                        $attr->attr_price = $_v[2]; //如果为字符串attr_price存入数据库为0
                        if($attr->goods_id && $attr->attr_id && $attr->attr_value) $attr->save();
                    }
                }
                DB::commit();
                return Redirect::to('admin/goods');
            } else {
                return Redirect::back()->withInput()->withErrors('保存失败！');
            }
        }catch (\Exception $e){
             DB::rollBack();
             throw $e;
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
        $types = GoodsType::all(); //获取所有types
        $photos = $goods->photos;
        //to-do
        return view('admin.goods.edit')->with('goods', $goods)->with('types', $types)->with('cats',$cats)->with('photos', $photos);
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
			'goods_name' => 'required|max:255',
            'store_price' => 'required|numeric|min:0',
		]);

		$goods= Goods::find($id);
		$goods->goods_name= $request->input('goods_name');
		$goods->store_price= $request->input('store_price');
        //$post->slug = Str::slug(Input::get('title'));
		$goods->cat_id = Input::get('cat_id');
		$goods->desc = Input::get('desc');
		$goods->user_id = Auth::user()->id;
		$goods->type_id= Input::get('type_id'); //to-do
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

        //开始事务
        DB::beginTransaction();
        try{
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

                //商品关联属性
                //删除重复,goods_id,attr_id,attr_value
                $attrIdList = Input::get('attr_id_list');
                $attrValueList = Input::get('attr_value_list');
                $attrPriceList = Input::get('attr_price_list');
                $attrs = array_map(null, $attrIdList, $attrValueList, $attrPriceList);
                for($i=0; $i<count($attrs); $i++){
                    for($j=$i+1; $j<count($attrs); $j++){
                        if($attrs[$i][0] ==  $attrs[$j][0] && $attrs[$i][1] == $attrs[$j][1]){
                            unset($attrs[$i]);
                        }
                    }
                }
                

                //数据标记
                foreach($attrs as $_k=>$_v){
                    if(!GoodsAttr::where(['goods_id'=>$goods->id, 'attr_id'=>$_v[0], 'attr_value'=>$_v[1]])->first()){
                        $attrs[$_k]['sign'] = 'insert';
                    }elseif(GoodsAttr::where(['goods_id'=>$goods->id, 'attr_id'=>$_v[0], 'attr_value'=>$_v[1]])->first()){
                        $attrs[$_k]['sign'] = 'update';
                    }
                }

                //数据标记
                foreach($goods->goodsAttrs as $v){
                    $isDel = true;
                    foreach($attrs as $_v){
                        if($v['attr_id'] == $_v[0] && $v['attr_value'] == $_v[1]){
                            $isDel = false;
                        }
                    }
                    if($isDel){
                        $attrs[] = [$v['attr_id'], $v['attr_value'], 'sign'=>'delete'];
                    }
                }

                //数据操作
                foreach($attrs as $_v){
                    if($_v['sign'] == 'insert'){
                        $attr = new GoodsAttr;
                        $attr->goods_id = $goods->id;
                        $attr->attr_id = $_v[0];
                        $attr->attr_value = $_v[1];
                        $attr->attr_price = $_v[2]; //如果为字符串attr_price存入数据库为0
                        if($attr->goods_id && $attr->attr_id && $attr->attr_value) {
                            //删除存在的 
                            //$attrs::where(['goods_id'=>$attr->goods_id, 'attr_id'=>$attr->attr_id, 'attr_value'=>$attr->attr_value]);
                            //保存
                            $attr->save();   
                        }

                    }elseif($_v['sign'] == 'update'){
                        GoodsAttr::where(['goods_id'=>$goods->id, 'attr_id'=>$_v[0], 'attr_value'=>$_v[1]])->update(['attr_price'=>$_v[2]]);
                    }elseif($_v['sign'] == 'delete'){
                        $attr = GoodsAttr::where(['goods_id'=>$goods->id, 'attr_id'=>$_v[0], 'attr_value'=>$_v[1]])->delete();
                    }
                }
                DB::commit();
                return Redirect::to('admin/goods');
            } else {
                return Redirect::back()->withInput()->withErrors('保存失败！');
            }
        }catch (\Exception $e){
             DB::rollBack();
             throw $e;
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
