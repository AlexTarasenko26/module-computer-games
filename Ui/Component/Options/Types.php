<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Options;

class Types implements \Magento\Framework\Data\OptionSourceInterface
{
    const TYPE_OPTIONS = [
        ['label' => 'RPG', 'value' => 'RPG'],
        ['label' => 'RTS', 'value' => 'RTS'],
        ['label' => 'MMO', 'value' => 'MMO'],
        ['label' => 'Simulator', 'value' => 'Simulator'],
        ['label' => 'Shooter', 'value' => 'Shooter']
    ];

    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return self::TYPE_OPTIONS;
    }
}
