<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->string('id', 30);
            $table->text('description');
            $table->string('url');
            $table->string('category');
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('news_source')->nullable();
            $table->timestamps();
            $table->integer('last_updated')->default(0);
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
