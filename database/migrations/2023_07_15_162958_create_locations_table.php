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
        Schema::create('locations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId("item_id")->constrained();
            $table->string("address");
            $table->integer("zip_code");
            $table->foreignId("city_id")->constrained();
            $table->foreignId("state_id")->constrained();
            $table->foreignId("country_id")->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['item_id', 'city_id', 'state_id', 'country_id']);
        });
        Schema::dropIfExists('locations');
    }
};
