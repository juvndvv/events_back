<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\HttpClient;


enum Method
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
}
