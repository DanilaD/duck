<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

class ChangeDataTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_change_data_command()
    {
        // Call the Artisan command
        Artisan::call('ducks:update');

        // Check that the command output the correct messages
        $output = Artisan::output();
        $this->assertStringContainsString('Starting...', $output);
        $this->assertStringContainsString('Completed.', $output);
    }
}
