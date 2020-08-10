<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_comments', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('account_id');
          $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
          $table->unsignedBigInteger('comment_id');
          $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
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
        Schema::dropIfExists('like_comments');
    }
}
