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
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->unsignedBigInteger('presensi_id')->after('id');
            $table->foreign('presensi_id')->references('id')->on('presensi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->dropForeign(['presensi_id']);
            $table->dropColumn('presensi_id');
        });
    }
};
