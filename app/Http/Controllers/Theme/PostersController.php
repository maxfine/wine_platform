<?php namespace App\Http\Controllers\Theme;

use App\Http\Requests;
use App\Http\Controllers\Theme\ThemeController;

use Illuminate\Http\Request;

class PostersController extends ThemeController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
    public function show(Request $request, $id)
    {
        $this->validate($request, [
            'themeId' => 'numeric'
        ]);

        //营销类型
        $themeId = $request->input('themeId', 1); //默认百度
        $checkShow = TRUE; //是否显示广告
        $posterList = [];

        //广告数据
        $checkShow && $posterList =
            [
                ['url' => 'http://www.znyes.com', 'image' => 'https://placeholdit.imgix.net/~text?txtsize=33&txt=广告&w=100&h=450'],
                ['url' => 'http://www.znyes.com', 'image' => 'https://placeholdit.imgix.net/~text?txtsize=33&txt=广告&w=1000&h=90'],
            ];
        $setting = ['title' => '百度一下，你就知道', 'icon' => 'https://www.baidu.com/favicon.ico',  'iframeUrl' => 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=0&rsv_idx=1&tn=baidu&wd=百度'];

        $viewer = 'theme.posters.baidu';

        return view($viewer)->with('posterList', $posterList)->with('setting', $setting);
    }

    public function baiduShow(Request $request, $id)
    {
        $this->validate($request, [
            'themeId' => 'numeric'
        ]);

        //营销类型
        $themeId = $request->input('themeId', 1); //默认百度
        $checkShow = TRUE; //是否显示广告
        $posterList = [];

        //广告数据
        $checkShow && $posterList =
            [
                ['url' => 'http://www.znyes.com', 'image' => 'https://placeholdit.imgix.net/~text?txtsize=33&txt=广告&w=100&h=450'],
                ['url' => 'http://www.znyes.com', 'image' => 'https://placeholdit.imgix.net/~text?txtsize=33&txt=广告&w=1000&h=90'],
            ];
        $setting = ['title' => '百度一下，你就知道', 'icon' => 'https://www.baidu.com/favicon.ico',  'iframeUrl' => 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=0&rsv_idx=1&tn=baidu&wd=百度'];
        $viewer = 'theme.posters.baidu';

        return view($viewer)->with('posterList', $posterList)->with('setting', $setting);
    }

    public function haosouShow(Request $request, $id){

    }

    public function sogouShow(Request $request, $id){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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