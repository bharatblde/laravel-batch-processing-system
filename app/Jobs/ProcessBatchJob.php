<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TestRecord;
use App\Jobs\ProcessBatchJob;

class ProcessBatchCommand extends Command
{
    protected $signature = 'batch:process';

    protected $description = 'Process records in batches';

    public function handle()
    {
        TestRecord::where('status', true)
            ->chunk(25, function ($records) {

                ProcessBatchJob::dispatch(
                    $records->pluck('id')->toArray()
                )->onQueue('default');

            });

        $this->info('Batch jobs dispatched successfully!');
    }
}