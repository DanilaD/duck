<?php

namespace App\Jobs;

use App\Models\DuckModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
            // Find the duck by its ID or fail
            $duck = DuckModel::findOrFail($this->id);

            // Delete the duck
            $duck->delete();

            // Log a success message
            Log::info('Duck deleted successfully', ['id' => $this->id]);
        } catch (\Exception $e) {
            // Log an error message if something goes wrong
            Log::error('Error updating duck', ['id' => $this->id, 'error' => $e->getMessage()]);
        }
    }
}
