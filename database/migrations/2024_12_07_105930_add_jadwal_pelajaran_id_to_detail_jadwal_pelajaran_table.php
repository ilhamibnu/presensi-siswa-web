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
            $table->unsignedBigInteger('jadwal_pelajaran_id')->after('id');
            $table->foreign('jadwal_pelajaran_id')->references('id')->on('jadwal_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pelajaran', function (Blueprint $table) {
            $table->dropForeign(['jadwal_pelajaran_id']);
            $table->dropColumn('jadwal_pelajaran_id');
        });
    }
};
