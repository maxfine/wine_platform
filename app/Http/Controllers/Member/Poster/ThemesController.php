<?php namespace App\Http\Controllers\Member\Poster;

use App\Http\Requests;
use App\Http\Controllers\Member\MemberController;

use Illuminate\Http\Request;
use App\Models\PosterTheme;

class ThemesController extends MemberController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //todo
        $userId = \Auth::user()->id;
        $posterThemes = PosterTheme::where('user_id', '=', $userId)->get();
        return view('member.poster.themes.index')->with('posterThemes', $posterThemes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('member.poster.themes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
        return view('member.poster.themes.edit')->with('posterTheme', PosterTheme::findOrFail($id));
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
		//
	}

}
