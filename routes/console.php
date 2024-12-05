<?php

use Illuminate\Support\Facades\Schedule;
use Modules\Article\Console\FetchNewsApiData;

Schedule::command(FetchNewsApiData::class)->daily();
