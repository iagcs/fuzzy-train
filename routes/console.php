<?php

use Illuminate\Support\Facades\Schedule;
use Modules\Article\app\Console\FetchNewsApiData;

Schedule::command(FetchNewsApiData::class)->daily();
