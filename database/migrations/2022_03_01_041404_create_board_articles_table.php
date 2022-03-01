<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET GLOBAL innodb_large_prefix = ON;'); 
        Schema::create('board_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 45)->unique();
            $table->bigInteger('board_info_id')->unsigned()->index()->nullable(false)->comment('board_infos 참조키')->index();
            $table->bigInteger('board_category_id')->unsigned()->nullable(true)->comment('board_categories 참조키')->index();
            $table->bigInteger('user_id')->unsigned()->nullable(false)->comment('users 참조키')->index();
            $table->bigInteger('back_id')->unsigned()->nullable(true)->comment('이전 게시글 id');
            $table->bigInteger('next_id')->unsigned()->nullable(true)->comment('다음 게시글 id');

            $table->bigInteger('parent_id')->unsigned()->nullable(true)->comment('게시글 정렬 항목');
            $table->bigInteger('field_sort')->unsigned()->nullable(true)->comment('게시글 정렬 항목');
            $table->bigInteger('depth')->unsigned()->nullable(true)->comment('게시글 정렬 항목');
            $table->string('user_user_name', 50)->nullable(true)->comment('사용자 아이디');
            $table->string('user_real_name', 100)->nullable(true)->index()->comment('사용자 실제이름');
            $table->string('user_ip', 15)->nullable(true)->comment('사용자 ip');
            $table->string('user_password', 128)->nullable(true)->comment('사용자 비밀번호');
            $table->string('user_email', 128)->nullable(true)->comment('사용자 이메일');
            $table->string('user_contact', 14)->nullable(true)->comment('사용자 연락처');
            $table->string('title', 255)->nullable(false)->index()->comment('제목');
            $table->longText('content')->nullable(true)->comment('내용');
            $table->bigInteger('view_count')->unsigned()->nullable(true)->comment('조회수');
            $table->bigInteger('ment_count')->unsigned()->nullable(true)->comment('댓글 수');
            $table->bigInteger('child_count')->unsigned()->nullable(true)->comment('자식 게시물 수');
            $table->boolean('notify_reply')->default(false)->comment('답글 가능 여부');
            $table->string('notify_reply_contact', 14)->nullable(true)->comment('답글 알림 연락처');
            $table->boolean('subject_bold')->default(false)->comment('제목 굵게 여부');
            $table->boolean('secret')->default(false)->comment('비공개 여부');
            $table->boolean('public')->default(false)->comment('노출 여부 여부');
            $table->timestamps();
            $table->foreign('board_info_id')->references('id')->on('board_infos')->onDelete('cascade');
            $table->foreign('board_category_id')->references('id')->on('board_categories')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['board_info_id', 'board_category_id'], 'multi_index1');
            $table->index(['board_info_id', 'title', 'user_real_name'], 'multi_index2');
            $table->index(['board_info_id', 'board_category_id', 'title', 'user_real_name'], 'multi_index3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_articles');
    }
}
