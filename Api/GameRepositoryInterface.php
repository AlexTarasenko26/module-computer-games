<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Api;

use Epam\ComputerGames\Api\Data\GameInterface as GameInterface;

interface GameRepositoryInterface
{
    /**
     * @param int $gameId
     * @return GameInterface
     */
    public function getById($gameId): GameInterface;

    /**
     * @param GameInterface $game
     * @return int
     */
    public function save(GameInterface $game): int;

    /**
     * @param GameInterface $game
     * @return boolean
     * @throws \Exception
     */
    public function delete(GameInterface $game): bool;

    /**
     * @param int $gameId
     * @return bool
     */
    public function deleteById($gameId): bool;

}
