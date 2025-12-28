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
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'address') && ! Schema::hasColumn('profiles', 'birthdate') && ! Schema::hasColumn('profiles', 'image')) {
                $table->string('address')->nullable();
                $table->date('birthdate')->nullable();
                $table->string('image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('profiles', 'birthdate')) {
                $table->dropColumn('birthdate');
            }
            if (Schema::hasColumn('profiles', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
