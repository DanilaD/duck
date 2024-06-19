<?php

namespace App\Jobs;

use App\Models\DuckModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateDuckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;  // ID of the duck to be updated
    protected $data;  // Data to update the duck with

    /**
     * Create a new job instance.
     *
     * @param string $id
     * @param array $data
     * @return void
     */
    public function __construct(string $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Find the duck by its ID or throw an exception if not found
            $duck = DuckModel::findOrFail($this->id);

            // Update the duck with the provided data
            $duck->update($this->data);

            // Log a success message
            Log::info('Duck updated successfully', ['id' => $this->id]);
        } catch (\Exception $e) {
            // Log an error message if something goes wrong
            Log::error('Error updating duck', ['id' => $this->id, 'error' => $e->getMessage()]);
        }
    }
}
