<?php

namespace App\Console\Commands;

use App\Jobs\UpdateDuckDataJob;
use App\Models\DuckModel;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;

class changeData extends Command
{
    // The name and signature of the console command
    protected $signature = 'ducks:update';

    // The console command description
    protected $description = 'Generate new data for ducks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Log the start of the command execution
        $this->info("Starting...");

        // Record the start time to calculate elapsed time later
        $start = microtime(true);

        // Process ducks in chunks to handle large datasets efficiently
        DuckModel::chunk(5000, function ($ducks) {
            // Dispatch a job for each chunk of ducks
            UpdateDuckDataJob::dispatch($ducks);
            $this->info("Created a Job.");
        });

        // Calculate the elapsed time and log it
        $time = $this->calculateElapsedTime($start);
        $this->info("Time elapsed: $time");
        $this->info("Completed.");
    }

    /**
     * Calculate and format the elapsed time.
     *
     * @param string $start The start time in microseconds
     * @return string The formatted elapsed time
     */
    private function calculateElapsedTime(string $start): string
    {
        // Record the finish time
        $finish = microtime(true);

        // Calculate the elapsed time in seconds
        $timeElapsed = $finish - $start;

        // Convert the elapsed time into a CarbonInterval object
        $interval = CarbonInterval::seconds($timeElapsed);

        // Format the interval into a human-readable string
        return $interval->cascade()->forHumans();
    }
}
