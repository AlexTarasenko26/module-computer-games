<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Api\Data;

interface GameInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const GAME_ID = 'game_id';
    const NAME = 'name';
    const IMAGE = 'image';
    const TYPE = 'type';
    const TRIAL_PERIOD = 'trial_period';
    const RELEASE_DATE = 'release_date';

    /**
     * @return int
     */
    public function getGameId(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setGameId(int $id);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type);

    /**
     * @return int
     */
    public function getTrialPeriod(): int;

    /**
     * @param int $period
     * @return void
     */
    public function setTrialPeriod(int $period);

    /**
     * @return string
     */
    public function getReleaseDate(): string;

    /**
     * @param string $date
     * @return void
     */
    public function setReleaseDate(string $date);
}
