<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->unqiue()->comment('本地订单ID');
            $table->integer('store_id')->comment('商铺ID');
            $table->string('user_id')->comment('下单人ID');
            $table->string('out_trade_no')->comment('商户订单ID，第三方提供');
            $table->string('body')->comment('商品描述');
            $table->text('detail')->comment('商品详情');
            $table->string('attach')->comment('附加信息');
            $table->unsignedInteger('status')->default(0)->comment('订单状态');
            $table->text('created_ip');
            $table->timestamps();

            $table->primary('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
