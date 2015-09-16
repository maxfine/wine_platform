<?php namespace App\Http\Controllers\Member\Poster;

use App\Http\Requests;
use App\Http\Controllers\Member\MemberController;

use Illuminate\Http\Request;
use App\Models\PosterTheme;
use Redirect, Input, Auth, URL;

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
	public function store(Request $request)
	{
        $this->validate($request, [
            'site_url' => 'required',
        ]);

        $posterTheme = new PosterTheme();
        $posterTheme->site_url = e(Input::get('site_url'));
        $posterTheme->image100x450 = Input::get('thumb')?e(Input::get('thumb')):'';
        $posterTheme->image1000x90 = Input::get('thumb2')?e(Input::get('thumb2')):'';
        $posterTheme->template_id = 1;
        $posterTheme->status = 1;
        $date = new \DateTime;
        $posterTheme->end_at = $date->modify('+3 day');
        $posterTheme->user_id = Auth::user()->id;

        if ($posterTheme->save()) {
            return Redirect::to('member/poster/themes');
        } else {
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
