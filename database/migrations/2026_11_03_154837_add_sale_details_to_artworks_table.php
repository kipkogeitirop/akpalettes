<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->string('availability')->nullable()->after('category');
            $table->string('medium')->nullable()->after('availability');
            $table->string('dimensions')->nullable()->after('medium');
            $table->boolean('in_hero')->default(false)->after('featured');
        });

        DB::table('artworks')
            ->whereIn('slug', ['woman-with-a-basket', 'krishna-and-the-herd', 'tree-of-peacocks', 'the-stag-in-bloom'])
            ->update(['in_hero' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn(['availability', 'medium', 'dimensions', 'in_hero']);
        });
    }
};
