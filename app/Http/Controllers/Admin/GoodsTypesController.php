<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\GoodsType;
use App\Models\Attribute;

use Redirect, Input, Auth;

class GoodsTypesController extends Controller {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('admin.goods_types.index')->withTypes(GoodsType::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.goods_types.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
   		$this->validate($request, [
			'type_name' => 'required|unique:goods_types|max:255',
		]);

        $goodsType = new GoodsType;
		$goodsType->type_name = Input::get('type_name');

		if ($goodsType->save()) {
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
        return view('admin.goods_types.show')->withType(GoodsType::find($id)); 
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('admin.goods_types.edit')->withType(GoodsType::find($id));
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
			'type_name' => 'required|max:255',
		]);

        $goodsType = GoodsType::find($id);
		$goodsType->type_name = Input::get('type_name');

		if ($goodsType->save()) {
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
        $type = GoodsType::find($id);
		$type->delete();

		return Redirect::to('admin/goods_types');
	}

}
