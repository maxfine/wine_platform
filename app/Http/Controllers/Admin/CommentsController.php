<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use Redirect, Input, Auth;

class CommentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.comments.index')->with('comments',Comment::paginate(10));
    }

    /**
     * -------------------------------------------
     * 查询某篇文章或某个商品下的评论
     * -------------------------------------------
     */
    public function commentList($post_id, $type)
    {
        $comments = Comment::where(['post_id'=>$post_id, 'type'=>$type])->paginate(10);
        return view('admin.comments.list')->with('comments', $comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($post_id, $type=0)
    {
        if(!Comment::canBuild($post_id, $type))return;
        return view('admin.comments.create')->with('post_id', $post_id)->with('type', $type);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $comment= new Comment;
        $comment->post_id = Input::get('post_id');
        $comment->type = Input::get('type');
        $comment->content = Input::get('content');
        $comment->user_id = Auth::user()->id;

        if ($comment->save()) {
            return Redirect::to('admin/comments');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
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

        $comment = Comment::find($id);
        return view('admin.comments.show')->with('comment', $comment); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $comment= Comment::find($id);
        //$article = $comment->article;
        return view('admin.comments.edit')->with('comment', $comment);
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
            'content' => 'required',
        ]);

        $comment= Comment::find($id);
        $comment->content = Input::get('content');

        if ($comment->save()) {
            return Redirect::to('admin/comments');
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
        //同时删除所有评论
        $comment= Comment::find($id);
        $comment->delete();

        return Redirect::to('admin/comments');
    }
}
