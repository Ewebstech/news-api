<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source_id', 30);
            $table->string('author')->nullable();
            $table->string('title');
            $table->text('description');
            $table->text('url');
            $table->text('urlToImage');
            $table->timestamp('publishedAt');
            $table->timestamps();
            $table->integer('last_updated')->default(0);
            $table->foreign('source_id')->references('id')->on('sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
