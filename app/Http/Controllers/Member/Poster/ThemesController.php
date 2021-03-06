<?php namespace App\Http\Controllers\Member\Poster;

use App\Http\Requests;
use App\Http\Controllers\Member\MemberController;

use Illuminate\Http\Request;
use App\Models\PosterTheme;
use Redirect, Input, Auth, URL, DB, Response;

class ThemesController extends MemberController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //获取折扣
        $member = Auth::user();
        if($member->userGroup){
            $discount = $member->userGroup->discount;
        }

        $userId = Auth::user()->id;
        $posterThemes = PosterTheme::where('user_id', '=', $userId)->get();
        foreach($posterThemes as $posterTheme){
            $posterTheme->price = 1000;
            if(isset($discount) && $discount){
                $posterTheme->price = $posterTheme->price * $discount/100;
            }
        }

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
	public function edit(Request $request, $id)
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
     * 续费页面
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function renewEdit($id)
    {
        $posterTheme = PosterTheme::findOrFail($id);
        return view('member.poster.themes.renew_edit')->with('posterTheme', $posterTheme);
    }

    /**
     * 续费
     * 修改end_at
     *
     * @param $id
     */
    public function renew($id)
    {
        $years = 1; //再续多少年
        $posterTheme = PosterTheme::findOrFail($id);
        $member = Auth::user();
        $itemPrice = 1000;
        //折扣后的价格
        if($member->userGroup){
            $discount = $member->userGroup->discount;
            $discount && $itemPrice = $itemPrice * $discount/100;
        }

        $end_at = new \DateTime($posterTheme->end_at);
        $now = new \DateTime();
        if($end_at->getTimestamp() < $now->getTimestamp()){
            $posterTheme->end_at = $now->modify('+'.$years.' Year');
        }else{
            $posterTheme->end_at = $end_at->modify('+'.$years.' Year');
        }
        $member->amount = $member->amount - $years * $itemPrice;

        DB::beginTransaction();
        try{
            if($member->amount >= 0){
                //todo 减账户资金
                if($member->save()){
                    $posterTheme->save();
                }
                DB::commit();
                return Redirect::to('member/poster/themes');
            }
            else{
                //return Redirect::back()->withErrors('续费失败！');
                return Redirect::back()->withErrors('续费失败, 余额不足！');
            }
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
