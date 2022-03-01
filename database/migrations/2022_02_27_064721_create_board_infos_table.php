<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 1)->comment('종류(A:일반, B:이미지, E:Q&A, H:FAQ, I:1대1)')->index();
            $table->string('title', 255)->comment('이름');
            $table->string('read', 10)->comment('읽기권한');
            $table->string('write', 10)->comment('쓰기권한');
            $table->string('reply', 10)->comment('답글권한');
            $table->string('comment', 10)->comment('댓글권한');
            $table->string('comment_use', 1)->nullable(true)->default("N")->comment('댓글 사용여부');
            $table->string('reply_use', 1)->nullable(true)->default("N")->comment('답글 사용여부');
            $table->string('file_use', 1)->nullable(true)->default("N")->comment('파일첨부 사용여부');
            $table->string('secret_use', 1)->nullable(true)->default("N")->comment('비밀글 사용여부');
            $table->string('notice_use', 1)->nullable(true)->default("N")->comment('공지사항 사용여부');
            $table->string('search_use', 1)->nullable(true)->default("Y")->comment('검색 사용여부');
            $table->string('notify_email_use', 1)->nullable(true)->default("N")->comment('게시물 등록 이메일 알림 사용여부');
            $table->string('notify_sms_use', 1)->nullable(true)->default("N")->comment('게시물 등록 문자 알림 사용여부');
            $table->string('notify_email', 255)->comment('게시물 등록 이메일 알림 정보 - 이메일리스트 `,` 구분자');
            $table->string('notify_sms', 255)->comment('게시물 등록 문자 알림 정보 - 문자리스트 `,` 구분자');
            $table->unsignedInteger('article_count')->nullable(true)->default(0)->comment('게시글 수');
            $table->dateTimeTz('last_article_date')->nullable(true)->comment('마지막 게시물 등록시간');
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
        Schema::dropIfExists('board_infos');
    }
}
