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
        Schema::connection('penampungan')->create('integration_claims', function (Blueprint $table) {
            $table->id();
            $table->string('sub_cob');
            $table->string('penyebab_klaim');
            $table->date('periode');
            $table->string('id_wilker');
            $table->date('tgl_keputusan_klaim');
            $table->decimal('jumlah_terjamin', 15, 2);
            $table->decimal('nilai_beban_klaim', 15, 2);
            $table->string('debet_kredit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration');
    }
};
