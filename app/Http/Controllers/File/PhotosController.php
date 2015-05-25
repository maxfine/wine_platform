<?php
namespace App\Http\Controllers\File;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Handlers\Commands\UploadHandler;

class PhotosController extends Controller{
    private $upload;
    private $script_url;
    private $upload_url;
    private $fileName;
    
    public function __construct(){
        $this->script_url = URL('file/photos/delete_image');
        $this->upload_dir = public_path().'/uploads/images/';
        $this->upload_url = URL('/').'/uploads/images/';
        $this->fileName = 'files';
    }

    private function setUpload(){
        $options = [
            'script_url' => $this->script_url,
            'upload_dir' => $this->upload_dir,
            'upload_url' => $this->upload_url,
            'user_dirs' => true,
            'mkdir_mode' => 0755,
            'param_name' => $this->fileName,
        ];
        $this->upload = new UploadHandler($options, true, null);
    }

    private function getUpload(){
        return $this->upload;
    }

    public function uploadImage($fileName){
        $this->fileName = $fileName;
        $this->setUpload();
        //$this->upload->initialize();
    }

    public function deleteImage(){
        $this->setUpload();
    }

   /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //return view('AdminHome')->with('pages',Page::all())->with('articleCats',ArticleCat::all())->with('articles', Article::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $this->setUpload();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $this->setUpload();
	}

    

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $this->setUpload();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->setUpload();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->setUpload();
	} 
}
