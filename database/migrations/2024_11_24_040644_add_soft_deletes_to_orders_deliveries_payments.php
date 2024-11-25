<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToOrdersDeliveriesPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->softDeletes()->after('status'); // Menambahkan kolom deleted_at setelah kolom status
        });

        Schema::table('deliveries', function (Blueprint $table) {
            $table->softDeletes()->after('status'); // Menambahkan kolom deleted_at setelah kolom status
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->softDeletes()->after('amount'); // Menambahkan kolom deleted_at setelah kolom amount
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
