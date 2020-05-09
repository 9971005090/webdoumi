<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hash_name', 45)->nullable(false)->comment('파일이름 변환한 해쉬값-확장자제외');
            $table->string('file_path', 255)->nullable(false)->comment('storage 하위의 파일 디렉토리 경로');
            # 풀 url 만들기 위한 경로값
            $table->string('file_local_name', 100)->nullable(false)->comment('storage에 저장된 파일명');
            $table->string('file_original_name', 255)->nullable(false)->comment('실 파일명');
            $table->string('file_mime_type', 255)->nullable(false)->comment('파일 mime type');
            $table->string('file_extension', 10)->nullable(false)->comment('파일 type');
            $table->unsignedInteger('file_size')->nullable(false)->comment('파일 size, byte');
            $table->string('file_size_string', 45)->nullable(false)->comment('파일 size, kb, mb, gb로 변환한 값, 예) 14.2kb');
            $table->boolean('is_use')->default(false)->nullable(false)->comment('사용여부');
            # plupload를 이용해서 업로드는 됐지만, 실제 저장 해당 파일을 업로드한 서비스에서 사용하는지 여부
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_files');
    }
}
