<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_jadwal_pelajaran', function (Blueprint $table) {
            $table->unsignedBigInteger('hari_id')->after('id');
            $table->foreign('hari_id')->references('id')->on('hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_jadwal_pelajaran', function (Blueprint $table) {
            $table->dropForeign(['hari_id']);
            $table->dropColumn('hari_id');
        });
    }
};
