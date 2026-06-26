<?php

namespace App\Enums;

enum ProductSort: string
{
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case RATING_DESC = 'rating_desc';
    case NEWEST = 'newest';
}
