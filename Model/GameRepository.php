<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Model;

use Epam\ComputerGames\Api\Data\GameInterface;
use Epam\ComputerGames\Api\GameRepositoryInterface;
use Epam\ComputerGames\Model\ResourceModel\Game as GameResourceModel;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class GameRepository implements GameRepositoryInterface
{

    /**
     * @param GameResourceModel $gameResourceModel
     * @param GameFactory $gameFactory
     */
    public function __construct(
        private readonly GameResourceModel $gameResourceModel,
        private readonly GameFactory       $gameFactory
    )
    {

    }

    /**
     * @param int $gameId
     * @return GameInterface
     * @throws NoSuchEntityException
     */
    public function getById($gameId): GameInterface
    {
        $game = $this->gameFactory->create();
        $this->gameResourceModel->load($game, $gameId);
        if (!$game->getGameId()) {
            throw new NoSuchEntityException(
                __('There is no game with id %1', $gameId)
            );
        }
        return $game;
    }

    /**
     * @param GameInterface $game
     * @return int
     * @throws AlreadyExistsException
     */
    public function save(GameInterface $game): int
    {
        $this->gameResourceModel->save($game);
        return $game->getGameId();
    }

    /**
     * @param GameInterface $game
     * @return true
     * @throws \Exception
     */
    public function delete(GameInterface $game): bool
    {
        try {
            $this->gameResourceModel->delete($game);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param $gameId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($gameId): bool
    {
        return $this->delete($this->getById($gameId));
    }
}
