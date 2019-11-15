<?php

namespace App\Twig;

use App\Util\Formatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_price', [Formatter::class, 'formatPrice']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_discount_value', [Formatter::class, 'formatDiscountValue']),
        ];
    }
}
