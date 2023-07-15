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
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part00.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part01.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part02.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part03.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part04.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part05.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part06.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part07.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part08.sql'));
        DB::unprepared($sqlDump);
        $sqlDump = file_get_contents(database_path('migrations/sql/cities_part09.sql'));
        DB::unprepared($sqlDump);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
