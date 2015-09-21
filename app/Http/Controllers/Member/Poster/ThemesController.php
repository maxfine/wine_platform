<?php namespace App\Http\Controllers\Member\Poster;

use App\Http\Requests;
use App\Http\Controllers\Member\MemberController;

use Faker\Provider\zh_TW\DateTime;
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
        $userId = Auth::user()->id;
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
        if($data = PosterTheme::where(['id' => $id, 'user_id' => Auth::user()->id])->first()) return view('member.poster.themes.edit')->with('data', $data);
        return Redirect::to('member/poster/themes')->withErrors('没有权限');
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
            'site_url' => 'required',
        ]);

        $posterTheme = PosterTheme::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        $posterTheme->site_url = e(Input::get('site_url'));
        $posterTheme->image100x450 = Input::get('thumb')?e(Input::get('thumb')):'';
        $posterTheme->image1000x90 = Input::get('thumb2')?e(Input::get('thumb2')):'';

        if ($posterTheme->save()) {
            return Redirect::to('member/poster/themes');
        } else {
            return Redirect::back()->withInput($request->input())->withErrors('保存失败！');
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
        $posterTheme = PosterTheme::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        $posterTheme->delete();

        return Redirect::to('member/poster/themes');
	}

    public function multiDestroy($ids)
    {
        //todo
    }

    /**
     * 续费
     *
     * @param $id
     */
    public function renew($id)
    {
        $years = 1; //再续多少年
        $posterTheme = PosterTheme::findOrFail($id);

        $end_at = new \DateTime($posterTheme->end_at);
        $now = new \DateTime();
        if($end_at->getTimestamp() < $now->getTimestamp()){
            $posterTheme->end_at = $now->modify('+'.$years.' Year');
        }else{
            $posterTheme->end_at = $end_at->modify('+'.$years.' Year');
        }

        if ($posterTheme->save()) {
            //todo 减账户资金
            return Redirect::to('member/poster/themes');
        } else {
            return Redirect::back()->withErrors('续费失败！');
        }
    }
}
