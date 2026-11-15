<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Un journal pouvait être lié à un seul devis (journals.devis_id) :
        // table de liaison pour en rattacher plusieurs
        Schema::create('journal_invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id')->index();
            $table->unsignedBigInteger('invoice_id')->index();
            $table->timestamps();
            $table->unique(['journal_id', 'invoice_id']);
        });

        // Les liens existants sont repris
        $existants = DB::table('journals')
            ->whereNotNull('devis_id')
            ->where('devis_id', '>', 0)
            ->get(['id', 'devis_id']);
        foreach ($existants as $journal) {
            if (DB::table('invoices')->where('id', $journal->devis_id)->exists()) {
                DB::table('journal_invoice')->insertOrIgnore([
                    'journal_id' => $journal->id,
                    'invoice_id' => $journal->devis_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_invoice');
    }
};
