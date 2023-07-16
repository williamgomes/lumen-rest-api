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
        Schema::create('items', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('hotelier_id')->constrained();
            $table->string('name')->nullable(false);
            $table->integer('rating')->default(0);
            $table->enum('category', [
                'hotel',
                'alternative',
                'hostel',
                'lodge',
                'resort',
                'guest-house',
            ])->nullable(false);
            $table->string('image')->nullable(false);
            $table->integer('reputation')->default(0);
            $table->foreignId('badge_id')->constrained();
            $table->float('price')->default(0);
            $table->integer('availability')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['badge_id']);
        });

        Schema::dropIfExists('items');
    }
};
