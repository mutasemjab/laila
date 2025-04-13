<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('current_occupancy')->default(0);
            $table->timestamp('last_check_in')->nullable();
            $table->timestamps();
        });

        DB::table('rooms')->insert([
            ['name' => 'Room 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Room 2', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Room 3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
