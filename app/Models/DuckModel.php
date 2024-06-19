<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Eloquent\Builder;

class DuckModel extends Eloquent
{
    use HasFactory;

    // Specify the database connection to use for this model
    protected $connection = 'mongodb';

    // Specify the collection name for this model
    protected $collection = 'ducks';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'name', 'age', 'health', 'status', 'behaviors', 'last_fed_time'
    ];

    // Define the attribute casting
    protected $casts = [
        'age'           => 'integer',
        'health'        => 'integer',
        'status'        => 'string',
        'last_fed_time' => 'datetime',
        'behaviors'     => 'array',
    ];

    /**
     * Get the ducks count by status.
     *
     * This method builds a query to search for ducks based on provided criteria.
     *
     * @param array $search
     * @return Builder
     */
    public static function searchQuery(array $search): Builder
    {
        // Start building the query
        $query = self::query();

        // Apply filters based on the search criteria
        collect($search)->each(function ($value, $key) use ($query) {
            if ($value) {
                if ($key === 'name') {
                    // Use 'like' for partial matches on the name
                    $query->where($key, 'like', '%' . $value . '%');
                } else {
                    // Use '=' for exact matches on other fields
                    $query->where($key, '=', $value);
                }
            }
        });

        // Return the built query
        return $query;
    }

    /**
     * Get unique ages of ducks.
     *
     * This method retrieves distinct ages of ducks from the cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUniqueAges()
    {
        // Cache the distinct ages to improve performance
        return Cache::remember('ducks_count', 60, function () {
            return self::distinct('age')->get('age');
        });
    }
}
