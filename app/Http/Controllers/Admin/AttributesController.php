<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\GoodsType;
use App\Models\Attribute;

use Redirect, Input, Auth;

class AttributesController extends Controller {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('attrs.index')->withPages(Attribute::all());
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($typeId)
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
        $attr_vale = explode('\n\r', Input::get('attr_value'));
        $attr->attr_value = serialize($attr_vale);

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
		$page->user_id = Auth::user()->id;

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
