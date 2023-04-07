<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packets', function (Blueprint $table) {
            $table->integer('back_id')->after('purchase_date')->nullable();
            $table->integer('front_id')->after('purchase_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packets', function (Blueprint $table) {
            $table->dropColumn('back_id');
            $table->dropColumn('front_id');
        });
    }
};
