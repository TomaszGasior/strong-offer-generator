<?php

namespace App\Twig;

use App\Util\Formatter;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_price', [Formatter::class, 'formatPrice']),
            new TwigFilter('localized_date', [$this, 'localizedDate'], ['needs_environment' => true]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_discount_value', [Formatter::class, 'formatDiscountValue']),
        ];
    }

    public function localizedDate(Environment $twig, $date): string
    {
        $date = twig_date_converter($twig, $date);

        $formatter = new \IntlDateFormatter(null, null, null);
        $formatter->setPattern('d MMMM Y');

        return $formatter->format($date->getTimestamp());
    }
}
