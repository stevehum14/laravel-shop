<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('分类名称');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('父类ID');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->boolean('is_directory')->comment('是否有子分类，0：无，1：有');
            $table->unsignedInteger('level')->comment('当前类目层级');
            $table->string('path')->comment('该类目所有父类目ID，已经是最高父类默认为：-');
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
        Schema::dropIfExists('categories');
    }
}
