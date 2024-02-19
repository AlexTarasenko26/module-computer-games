<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Game extends AbstractDb
{
    private const TABLE_NAME = 'computer_games';
    private const PRIMARY_KEY = 'game_id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}
