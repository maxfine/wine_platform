<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\BackController;

use Illuminate\Http\Request;
use App\Models\Permission;
use Redirect, Input, Auth, URL;

class PermissionsController extends BackController {

    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $permissions = Permission::all();
        return view('admin.permissions.index')->with('permissions', $permissions);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.permissions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $this->validate($request, [
            'name' => 'required|alpha_dash|unique:permissions|max:255',
            'display_name' => 'required|max:255'
        ]);

        $permission = new Permission();
        $permission->name = e($request->name);
        $permission->display_name = e($request->display_name);

        if($permission->save()){
            return Redirect::to('admin/permissions');
        }else {
            return Redirect::back()->withInput($request->input())->withErrors('保存失败！');
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $permission = Permission::findOrFail($id);
        return view('admin.perssions.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return Redirect::to('admin/permissions');
	}

}
