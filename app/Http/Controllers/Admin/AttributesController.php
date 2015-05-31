<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Goods;
use App\Models\GoodsType;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use Illuminate\Support\Collection;

use Redirect, Input, Auth;

class AttributesController extends Controller {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $attrs = Attribute::paginate(10);
        return view('admin.attrs.index')->withAttrs($attrs);
	}

    /**
     * --------------------------------------------------------
     * 属性列表
     * --------------------------------------------------------
     */
    public function getList($typeId){
        $type = GoodsType::find($typeId);
        $attrs = Attribute::where('type_id', $type->id)->paginate(10);
        return view('admin.attrs.list')->with('attrs', $attrs)->with('typeId', $typeId);
    }

    /**
     * --------------------------------------------------------
     * ajax属性列表
     * --------------------------------------------------------
     */
    public function ajaxList(Request $request, $typeId, $goodsId=0){
        if( $request->ajax() ){
            if($goodsId && Goods::find($goodsId)){
                $type = GoodsType::find($typeId);
                $attrs = Attribute::where('type_id', $type->id)->get();
                $goods = Goods::find($goodsId);
                $goodsAttrs = $goods->goodsAttrs;
                foreach($attrs as $v){
                    $v->attr_value = unserialize($v->attr_value);
                    $v->list = GoodsAttr::where(['attr_id'=>$v['id'], 'goods_id'=>$goodsId])->select('attr_value', 'attr_price')->get(); //[['attr_value'=>'', 'attr_price'=>''],...];
                }


                /************************
                $goods = Goods::find($goodsId);
                $goodsAttrs = $goods->goodsAttrs;
                foreach($goodsAttrs as $v){
                    $attr = Attribute::find($v['attr_id']);
                    $v->attr_value_list = unserialize($attr->attr_value);
                    $v->attr_name = $attr->attr_name;
                    $v->attr_type = $attr->attr_type;
                    $v->attr_input_type = $attr->attr_input_type;
                }
                //$goodsAttrs = GoodsAttr::where(['goods_id'=>$goodsId])->select('id', 'attr_id', 'attr_value as _value', 'attr_price')->get()->toArray();
                ******************************/
                return  response()->json($attrs);
            }else{
                $type = GoodsType::find($typeId);
                $attrs = Attribute::where('type_id', $type->id)->get();
                //属性值去序列化
                foreach($attrs as $attr){
                    $attr->attr_value = unserialize($attr->attr_value);
                }
                return  response()->json($attrs);
            }
        }else{
            return  response()->json($attrs);
        }
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($typeId=0)
	{
        $type = GoodsType::find($typeId);
        $types = GoodsType::all(); //获取所有types
		return view('admin.attrs.create')->with('types', $types)->with('type', $type);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
   		$this->validate($request, [
			'attr_name' => 'required|unique:attributes|max:255',
            'type_id' => 'required|numeric'
		]);

		$attr = new Attribute;
		$attr->attr_name = Input::get('attr_name');
		$attr->type_id = Input::get('type_id');
		$attr->attr_index = Input::get('attr_index'); //是否需要检索
		$attr->attr_type = Input::get('attr_type'); //属性是否可选
		$attr->attr_input_type = Input::get('attr_input_type'); //录入方式

        //序列化属性值
        $attr_vale = explode(PHP_EOL, Input::get('attr_value'));
        $attr->attr_value = serialize(array_filter(array_map('trim',$attr_vale)));

		if ($attr->save()) {
			return Redirect::to('admin/goods_types');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
		}

	}

    /**
     * 查看
     */
    public function show($id)
    {
        return view('admin.attrs.show')->withPage(Attribute::find($id)); 
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $attr = Attribute::find($id);
        $attr->attr_value = implode(PHP_EOL, unserialize($attr->attr_value));
		return view('admin.attrs.edit')->withAttr($attr)->with('types', GoodsType::all());
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
			'attr_name' => 'required|max:255',
            'type_id' => 'required|numeric'
		]);

		$attr = Attribute::find($id);
		$attr->attr_name = Input::get('attr_name');
		$attr->type_id = Input::get('type_id');
		$attr->attr_index = Input::get('attr_index'); //是否需要检索
		$attr->attr_type = Input::get('attr_type'); //属性是否可选
		$attr->attr_input_type = Input::get('attr_input_type'); //录入方式

        //序列化属性值
        $attr_vale = explode(PHP_EOL, Input::get('attr_value'));
        $attr->attr_value = serialize(array_filter(array_map('trim',$attr_vale)));

		if ($attr->save()) {
			return Redirect::to('admin/goods_types');
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
		$attr = Attribute::find($id);
		$attr->delete();

		return Redirect::to('admin/goods_types');
	}

}
