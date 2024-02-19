<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Api\Data;

use Epam\ComputerGames\Api\Data\GameInterface as GameInterface;

interface GameRepositoryInterface
{
    /**
     * @param int $id
     * @return GameInterface
     */
    public function get($id): GameInterface;

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

}
