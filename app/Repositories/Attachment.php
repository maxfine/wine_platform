<?php
/**
 * Created by 正言网络.
 * User: max_fine@qq.com
 * Date: 2015/7/2
 * Time: 16:27
 * 附件上传类
 */

namespace App\Repositories;


class Attachment {
    public function postAddFiles()
    {
        $name = Input::get('name');
        $files = Input::file('images');

        $inputs = array(
            'name' => $name,
            'images' => $files
        );
        foreach ($files as $file) {
            $rules = array(
                'name' => 'required',
                'images' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,rtf|max:20000'
            );
            $validator = Validator::make(array('images' => $file, 'name' => $name), $rules);
            if ($validator->passes()) {
                $id = Str::random(14);
                $destinationPath = public_path() . '/files/users/' . $id;
                $fileName = $file->getClientOriginalName();
                $mime_type = $file->getMimeType();
                $extension = $file->getClientOriginalExtension();
                $upload_success = $file->move($destinationPath, $fileName);
                $inputs["images"] = '/files/user/' . $fileName;
                $user = AddFile::create(array($files));
                return View::make('/pages/add-files')->with('msg', 'Your files are successfully submitted');
            } else {
                return View::make('/pages/add-files')->withErrors($validator);
            }
        }
        return Redirect::back()->with('success', 'not added.');
    }
}