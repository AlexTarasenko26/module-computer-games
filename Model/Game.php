<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Model;

use Epam\ComputerGames\Api\Data\GameInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Epam\ComputerGames\Model\ResourceModel\Game as ResourceModel;

class Game extends AbstractExtensibleModel implements GameInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return array
     */
    public function getCustomAttributesCodes()
    {
        return array('game_id', 'name', 'type', 'trial_period', 'release_date', 'image');
    }

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return (int) $this->getData(self::GAME_ID);
    }

    /**
     * @param int $id
     * @return void
     */
    public function setGameId(int $id): void
    {
        $this->setData(self::GAME_ID, $id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->setData(self::TYPE, $type);
    }

    /**
     * @return int
     */
    public function getTrialPeriod(): int
    {
        return $this->getData(self::TRIAL_PERIOD);
    }

    /**
     * @param int $period
     * @return void
     */
    public function setTrialPeriod(int $period): void
    {
        $this->setData(self::TRIAL_PERIOD, $period);
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->getData(self::RELEASE_DATE);
    }

    /**
     * @param string $date
     * @return void
     */
    public function setReleaseDate(string $date): void
    {
        $this->setData(self::RELEASE_DATE, $date);
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @param string $image
     * @return void
     */
    public function setImage(string $image): void
    {
        $this->setData(self::IMAGE, $image);
    }
}
