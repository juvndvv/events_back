<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\CurrencyExchange;


use App\Shared\Domain\Exceptions\AppException;
use App\Shared\Domain\Exceptions\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Currency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyExchangeService
{
    public static function updateExchangeRates(): void
    {
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if ($response->successful()) {
            $data = $response->json();
            $rates = $data['rates'];

            Cache::put('exchange_rates', $rates, 86400); // 24h

        } else {
            throw new AppException("Failed to fetch exchange rates from the external API.");
        }
    }

    public static function refreshExchangeRates(): void
    {
        try {
            self::updateExchangeRates();

        } catch (AppException $e) {
            echo 'Error: ' . $e->getMessage() . "\n";
        }
    }

    public static function convert(Currency $currency, string $targetCurrencyCode): Currency
    {
        if ($currency->code() === $targetCurrencyCode) {
            return $currency;
        }

        if (!Cache::has('exchange_rates')) {
            self::updateExchangeRates();
        }

        $exchangeRates = Cache::get('exchange_rates');

        if (!isset($exchangeRates[$targetCurrencyCode])) {
            throw new InvalidArgumentException("No exchange rate available for conversion from {$currency->code()} to $targetCurrencyCode");
        }

        $exchangeRate = $exchangeRates[$targetCurrencyCode];
        $newAmount = $currency->amount() * $exchangeRate;

        return Currency::create($newAmount, $targetCurrencyCode);
    }
}
