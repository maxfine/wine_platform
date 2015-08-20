<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;

use App\Models\ArticleCat;

use Redirect, Input, Auth;

class ArticleCatController extends CommonController {
    
    /**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getList($slug)
	{
		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();
		$post = $this->post->where('catId', '=', $post['id'])->get();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}

		// Get this post comments
		$articles= $post->comments()->orderBy('created_at', 'ASC')->get();

		// Show the page
		return view('article_cats.list')->with('articles',$articles);
	}
}
