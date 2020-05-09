<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    static $use_data_name = "UploadFile";
    static $table_name_ko = "업로드파일";

    protected $guarded = [];

    static $cascade = [
        'depth' => 0,
        'object' => []
    ];

    static $desc = [
        'class_name' => "UploadFile",
        'table_name' => [
            'ko' => "업로드파일"
        ]
    ];

    static $validate = [
        'base' => [
            'rule' => [
                'file' => 'max:10240'//kb
            ],
            'message' => [
                'file.max' => '1mb를 초과할 수 없습니다!'
            ]
        ],
        'user_profile_image' => [
            'rule' => [
                'file' => 'max:1024|mimes:jpg,jpeg,png,gif'//kb
            ],
            'message' => [
                'file.max' => '1mb를 초과할 수 없습니다!',
                'file.mimes' => 'jpg,jpeg,png,gif의 파일만 등록됩니다!'
            ]
        ],
        'board_image' => [
            'rule' => [
                'file' => 'required|max:1024000|mimes:jpg,jpeg,png,gif'//kb
            ],
            'message' => [
                'file.required' => '파일을 선택하세요!',
                'file.max' => '1000kb를 초과할 수 없습니다!',
                'file.mimes' => 'jpg,jpeg,png,gif의 파일만 등록됩니다!'
            ]
        ],
        'board_file' => [
            'rule' => [
                'file' => 'max:10240'//kb
            ],
            'message' => [
                'file.max' => '10kb를 초과할 수 없습니다!'
            ]
        ]
    ];

    static function get_info($id, $where_column="id")
    {
        if($id === null)
        {
            return null;
        }
        $upload_file = UploadFile::where([[$where_column, '=', $id]])->first();
        return $upload_file;
    }
}
