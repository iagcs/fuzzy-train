<?php

namespace Modules\Article\Console;

use App\Services\ElasticService;
use Illuminate\Console\Command;
use Modules\Article\Services\ArticlesApiServiceBase;
use Modules\Article\Services\NewsApiService;
use Modules\Article\Services\NewYorkTimesApiService;
use Modules\Article\Services\TheGuardiansApiService;

class FetchNewsApiData extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'fetch:news';

    /**
     * The console command description.
     */
    protected $description = 'Fetch news data inside the database.';

    /**
     * Create a new command instance.r
     */
    public function __construct(
        private readonly NewsApiService $newsApiService,
        private readonly TheGuardiansApiService $theGuardiansApiService,
        private readonly NewYorkTimesApiService $newYorkTimesApiService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        $this->newsApiService->fetchData();
        $this->theGuardiansApiService->fetchData();
        $this->newYorkTimesApiService->fetchData();
    }
}
