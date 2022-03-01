<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\UploadFile;
use Validator;
use App\Http\Controllers\CustomBaseController;
use App\Helpers\Custom\Utils As CustomUtils;

class FilemanagerController extends CustomBaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function upload(Request $request)
    {
        #Storage::putFileAs('test', new File($request['file']['tmp_name']), $request['file']['name']);
        /*
        request()->validate([

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1',

        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);
         */
        $validate = [
            'rule' => [
                // 'file' => 'required|max:10240|mimes:tff,woff'//kb
                'file' => 'required|max:10240|mimes:jpeg,png,jpg,gif,svg'//kb
            ],
            'message' => [
                'file.required' => '파일을 선택하세요!',
                'file.max' => '10kb를 초과할 수 없습니다!',
                'file.mimes' => 'jpeg,png,jpg,gif,svg의 파일만 등록됩니다!'
            ]
        ];
        #$this->validate($request, $validate['rule'], $validate['message']);
        #dd($this->validate($request, $validate['rule'], $validate['message']));
        #dd("1111");
        $validator = Validator::make($request->all(), $validate['rule'], $validate['message']);
        if($validator->passes() === false) //true/false
        {
            return response()->json(['error'=>$validator->errors()->all()], 400);
        }

        // return response()->json(['error'=>"1234"], 400);
        $request['file']->store("test");

        $file = [
            'hash_name' => str_replace(".".$request['file']->getClientOriginalExtension(), "", $request['file']->hashName()),
            'file_path' => "test",
            'file_local_name' => $request['file']->hashName(),
            'file_original_name' => $request['file']->getClientOriginalName(),
            'file_mime_type' => $request['file']->getMimeType(),
            'file_extension' => $request['file']->getClientOriginalExtension(),
            'file_size' => $request['file']->getSize(),
            'file_size_string' => CustomUtils::get_file_size($request['file']->getSize())
        ];
        // echo Config::get('filesystems.disks.local.root');
        $upload = UploadFile::create($file);
        return response()->json(
            [
                'result' => true,
                'file' => $upload
            ], 
        200);
        //Storage::delete('test/gCfaekazEkHDA9GvEduX1F9ICVAMLUfw25Drva4D.zip');

    }


    public function view(Request $request, $hash_name)
    {
        $upload_file = UploadFile::get_info($hash_name, "hash_name");
        if($upload_file == null)
        {
            return response(null, 200);
        }
        $file = Config::get('filesystems.disks.local.root')."/".$upload_file['file_path']."/".$upload_file['file_local_name'];
        $name = basename($file);
        //http://localhost:8000/filemanager/view/oS4AbELhEzGg7eaq7v2I9R7IMC3sfom5KtG5ypuW
        return response()->download($file, $name);
    }
}
