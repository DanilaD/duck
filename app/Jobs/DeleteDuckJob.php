<?php

namespace App\Jobs;

use App\Helpers\MongoDBConnection;
use App\Models\DuckModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use MongoDB\Client;

class DeleteDuckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;  // ID of the duck to be updated

    /**
     * Create a new job instance.
     *
     * @param string $id
     * @return void
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Get the MongoDB collection
            $collection = MongoDBConnection::getCollection('ducks');

            // Execute a raw query to delete the duck by its ID
            $result = $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($this->id)]);

            // Check if a document was deleted
            if ($result->getDeletedCount() > 0) {
                Log::info('Duck deleted successfully', ['id' => $this->id]);
            } else {
                Log::warning('No duck found to delete', ['id' => $this->id]);
            }
        } catch (\Exception $e) {
            // Log an error message if something goes wrong
            Log::error('Error deleting duck', ['id' => $this->id, 'error' => $e->getMessage()]);
        }
    }
}
