<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

enum HttpMethod
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
}
