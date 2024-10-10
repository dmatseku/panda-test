<?php

namespace App\Console\Commands;

use App\Services\PostApiService;
use Illuminate\Console\Command;

class ReviewPrices extends Command
{
    public function __construct(
        protected PostApiService $postApiService
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:review-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->postApiService->updatePostsInfo();
    }
}
