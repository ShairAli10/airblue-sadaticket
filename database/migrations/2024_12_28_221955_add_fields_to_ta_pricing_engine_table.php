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
        Schema::table('ta_pricing_engine', function (Blueprint $table) {
            $table->string('airline')->nullable();
            $table->string('type')->nullable();
            $table->string('amount')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ta_pricing_engine', function (Blueprint $table) {
            $table->dropColumn('airline');
            $table->dropColumn('type');
            $table->dropColumn('amount');
            $table->dropColumn('origin');
            $table->dropColumn('destination');
            $table->dropColumn('description');
        });
    }
};
