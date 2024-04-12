<?php

// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE events PARTITION BY RANGE (id) (
                PARTITION p0 VALUES LESS THAN (40),
                PARTITION p1 VALUES LESS THAN (80),
                PARTITION p2 VALUES LESS THAN (120),
                PARTITION p3 VALUES LESS THAN (160),
                PARTITION p4 VALUES LESS THAN (200),
                PARTITION p5 VALUES LESS THAN MAXVALUE
            )');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
