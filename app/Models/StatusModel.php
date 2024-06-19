<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class StatusModel extends Eloquent
{
    // Specify the database connection to use for this model
    protected $connection = 'mongodb';

    // Specify the collection name for this model
    protected $collection = 'statuses';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'name',
    ];

    /**
     * Get all statuses.
     *
     * This method retrieves all statuses from the cache or database, ordered by name.
     *
     * @return array
     */
    public static function getAll()
    {
        // Cache the statuses to improve performance
        return Cache::remember('cache_statuses', 60, function () {
            // Retrieve all statuses ordered by name and return them as an array
            return self::orderBy('name')->pluck('name')->toArray();
        });
    }
}
