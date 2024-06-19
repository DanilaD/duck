<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->collection('ducks', function (\MongoDB\Laravel\Schema\Blueprint $collection) {
            $collection->index('name');
            $collection->index('status');
            $collection->string('health');
            $collection->index('age');
            $collection->string(['behaviors.walking.is_walking']);
            $collection->string(['behaviors.breathing.is_breathing']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('mongodb')->getMongoDB()->dropCollection('ducks');
    }
};
