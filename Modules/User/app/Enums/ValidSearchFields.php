<?php

namespace Modules\User\Enums;

enum ValidSearchFields: string
{
    case KEYWORD = 'keyword';
    case CATEGORY = 'category';
    case SOURCE = 'source';
    case FROM = 'from';
}
