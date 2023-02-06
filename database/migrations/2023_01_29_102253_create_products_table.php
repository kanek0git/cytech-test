<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            // 外部キーの型は符号なしBIGINT
            $table->unsignedBigInteger('company_id');
            // 外部キー制約、親テーブル削除時に外部キーも自動削除されるようにonDeleteも付与
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('price');
            $table->integer('stock');
            $table->string('comment');
            $table->string('img_path');
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
        Schema::dropIfExists('products');
    }
}
