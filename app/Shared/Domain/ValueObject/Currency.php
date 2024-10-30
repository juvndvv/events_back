<?php

namespace App\Shared\Domain\ValueObject;


use App\Shared\Domain\Exceptions\InvalidArgumentException;

class Currency
{
    private float $amount;
    private string $code;

    private const CURRENCY_SYMBOLS = [
        'USD' => '$',
        'EUR' => '€',
        'AED' => 'د.إ',
        'AFN' => '؋',
        'ALL' => 'L',
        'AMD' => '֏',
        'ANG' => 'ƒ',
        'AOA' => 'Kz',
        'ARS' => '$',
        'AUD' => 'A$',
        'AWG' => 'ƒ',
        'AZN' => '₼',
        'BAM' => 'KM',
        'BBD' => 'Bds$',
        'BDT' => '৳',
        'BGN' => 'лв',
        'BHD' => '.د.ب',
        'BIF' => 'FBu',
        'BMD' => 'BD$',
        'BND' => 'B$',
        'BOB' => 'Bs.',
        'BRL' => 'R$',
        'BSD' => 'B$',
        'BTN' => 'Nu.',
        'BWP' => 'P',
        'BYN' => 'Br',
        'BZD' => 'BZ$',
        'CAD' => 'C$',
        'CDF' => 'FC',
        'CHF' => 'CHF',
        'CLP' => '$',
        'CNY' => '¥',
        'COP' => '$',
        'CRC' => '₡',
        'CUP' => '$',
        'CVE' => 'Esc',
        'CZK' => 'Kč',
        'DJF' => 'Fdj',
        'DKK' => 'kr',
        'DOP' => 'RD$',
        'DZD' => 'د.ج',
        'EGP' => '£',
        'ERN' => 'Nkf',
        'ETB' => 'Br',
        'FJD' => 'FJ$',
        'FKP' => '£',
        'FOK' => 'kr',
        'GBP' => '£',
        'GEL' => '₾',
        'GGP' => '£',
        'GHS' => '₵',
        'GIP' => '£',
        'GMD' => 'D',
        'GNF' => 'FG',
        'GTQ' => 'Q',
        'GYD' => 'G$',
        'HKD' => 'HK$',
        'HNL' => 'L',
        'HRK' => 'kn',
        'HTG' => 'G',
        'HUF' => 'Ft',
        'IDR' => 'Rp',
        'ILS' => '₪',
        'IMP' => '£',
        'INR' => '₹',
        'IQD' => 'ع.د',
        'IRR' => '﷼',
        'ISK' => 'kr',
        'JEP' => '£',
        'JMD' => 'J$',
        'JOD' => 'د.ا',
        'JPY' => '¥',
        'KES' => 'KSh',
        'KGS' => 'сом',
        'KHR' => '៛',
        'KID' => 'A$',
        'KMF' => 'CF',
        'KRW' => '₩',
        'KWD' => 'د.ك',
        'KYD' => 'CI$',
        'KZT' => '₸',
        'LAK' => '₭',
        'LBP' => 'ل.ل',
        'LKR' => 'Rs',
        'LRD' => 'L$',
        'LSL' => 'L',
        'LYD' => 'ل.د',
        'MAD' => 'د.م.',
        'MDL' => 'L',
        'MGA' => 'Ar',
        'MKD' => 'ден',
        'MMK' => 'K',
        'MNT' => '₮',
        'MOP' => 'MOP$',
        'MRU' => 'UM',
        'MUR' => '₨',
        'MVR' => 'Rf',
        'MWK' => 'MK',
        'MXN' => '$',
        'MYR' => 'RM',
        'MZN' => 'MT',
        'NAD' => 'N$',
        'NGN' => '₦',
        'NIO' => 'C$',
        'NOK' => 'kr',
        'NPR' => '₨',
        'NZD' => 'NZ$',
        'OMR' => 'ر.ع.',
        'PAB' => 'B/.',
        'PEN' => 'S/',
        'PGK' => 'K',
        'PHP' => '₱',
        'PKR' => '₨',
        'PLN' => 'zł',
        'PYG' => '₲',
        'QAR' => 'ر.ق',
        'RON' => 'lei',
        'RSD' => 'дин',
        'RUB' => '₽',
        'RWF' => 'FRw',
        'SAR' => 'ر.س',
        'SBD' => 'SI$',
        'SCR' => '₨',
        'SDG' => 'ج.س.',
        'SEK' => 'kr',
        'SGD' => 'S$',
        'SHP' => '£',
        'SLE' => 'Le',
        'SLL' => 'Le',
        'SOS' => 'Sh',
        'SRD' => '$',
        'SSP' => '£',
        'STN' => 'Db',
        'SYP' => '£',
        'SZL' => 'L',
        'THB' => '฿',
        'TJS' => 'SM',
        'TMT' => 'T',
        'TND' => 'د.ت',
        'TOP' => 'T$',
        'TRY' => '₺',
        'TTD' => 'TT$',
        'TVD' => 'A$',
        'TWD' => 'NT$',
        'TZS' => 'TSh',
        'UAH' => '₴',
        'UGX' => 'USh',
        'UYU' => '$U',
        'UZS' => 'soʼm',
        'VES' => 'Bs.S',
        'VND' => '₫',
        'VUV' => 'VT',
        'WST' => 'T',
        'XAF' => 'FCFA',
        'XCD' => '$',
        'XDR' => 'SDR',
        'XOF' => 'CFA',
        'XPF' => '₣',
        'YER' => '﷼',
        'ZAR' => 'R',
        'ZMW' => 'ZK',
        'ZWL' => 'Z$'
    ];

    private function __construct(float $amount, string $code)
    {
        if (!array_key_exists($code, self::CURRENCY_SYMBOLS)) {
            throw new InvalidArgumentException("Unsupported currency code: $code");
        }

        if ($amount < 0) {
            throw new InvalidArgumentException("Amount cannot be negative.");
        }

        $this->amount = $amount;
        $this->code = $code;
    }

    public static function create(float $amount, string $currencyCode): Currency
    {
        return new self($amount, $currencyCode);
    }

    public static function createFromString(string $currencyStr): Currency
    {
        $exploded = explode('|', $currencyStr);

        if (count($exploded) != 2) {
            throw new InvalidArgumentException("Invalid currency string: $currencyStr");
        }

        return new self($exploded[0], $exploded[1]);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        $symbol = self::CURRENCY_SYMBOLS[$this->code] ?? '';
        return sprintf('%s %.2f', $symbol, $this->amount);
    }
}
