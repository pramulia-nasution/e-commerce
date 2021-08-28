<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->enum('type',['fixed_total','percent']);
            $table->double('amount',10,2);
            $table->decimal('minimum_amount',15,2);
            $table->decimal('maximum_amount',15,2);
            $table->datetime('expired_date');
            $table->integer('coupon_total');
            $table->integer('user_limit');
            $table->integer('product_limit');
            $table->string('product_ids');
            $table->string('exclude_product_ids');
            $table->string('category_ids');
            $table->string('exclude_category_ids');
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
        Schema::dropIfExists('coupons');
    }
}
