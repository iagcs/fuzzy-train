<?php

namespace Modules\User\Dtos;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserDto extends Data
{
    public function __construct(
        public string | Optional $id,
        public string | Optional $name,
        public string | Optional $email,
        public string | Optional $password,
        public Carbon | Optional $created_at,
        public Carbon | Optional $updated_at,
    ) {}
}
