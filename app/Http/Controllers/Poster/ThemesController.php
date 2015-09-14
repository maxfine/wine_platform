<?php namespace App\Http\Controllers\Poster;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\PosterTheme;

/**
 * Created by maxfine<max_fine@qq.com>
 * Date: 2015/9/14
 * Time: 20:54
 */

class ThemesController extends CommonController{

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
            'templateId' => 'numeric'
        ]);

        //营销类型
        $templateId = $request->input('templateId', 1); //默认百度
        $posterTheme = PosterTheme::find($id);
        $posterList = [];

        $checkShow = ($posterTheme->status == 1) && (strtotime($posterTheme->end_at) + 3*24*60*60 > time()); //是否显示广告
        if(!$checkShow){
            $posterTheme['image100x450'] && $posterList[0] = ['image' => $posterTheme['image100x450'], 'url' => $posterTheme['site_url']];
            $posterTheme['image1000x90'] && $posterList[1] = ['image' => $posterTheme['image1000x90'], 'url' => $posterTheme['site_url']];
        }
        $template = $posterTheme->template->template;
        if(TRUE || !isset($template) || empty($template)){
            switch($templateId){
                case 1 :
                    $template = 'poster.themes.baidu';
                    break;
                case 2 :
                    $template = 'poster.themes.haosou';
                    break;
                case 3 :
                    $template = 'poster.themes.sogou';
                    break;
                default :
                    $template = 'poster.themes.baidu';
            }
        }

        return view($template)->with('posterList', $posterList);
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

    /**
     * 获取jump功能js文本
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getJs($id)
    {
        return view('poster.js_templates.jump')->with('id', $id);
    }

    /**
     * jsonp
     *
     * @param $callback
     * @param string $paramStr
     */
    public function jsonpCallback($callback, $paramStr = '')
    {
        echo $callback."($paramStr)";
    }

}