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
        Schema::create('statuses', function (Blueprint $collection) {
            $collection->string('name');
            $collection->timestamps();
        });

        DB::connection('mongodb')->collection('statuses')->insert([
            ['name' => 'active'],
            ['name' => 'resting'],
            ['name' => 'feeding'],
            ['name' => 'sleeping'],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
