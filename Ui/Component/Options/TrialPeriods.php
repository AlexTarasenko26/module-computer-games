<?php
declare(strict_types=1);
namespace Epam\ComputerGames\Ui\Component\Options;

class TrialPeriods implements \Magento\Framework\Data\OptionSourceInterface
{
    const PERIOD_OPTIONS = [
        ['label' => 'Month', 'value' => '1'],
        ['label' => 'Year', 'value' => '12'],
        ['label' => 'Life', 'value' => '0']
    ];

    public function toOptionArray()
    {
        return self::PERIOD_OPTIONS;
    }
}
