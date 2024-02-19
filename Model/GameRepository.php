<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Model;

use Epam\ComputerGames\Api\Data\GameInterface;
use Epam\ComputerGames\Api\Data\GameRepositoryInterface;
use Epam\ComputerGames\Model\ResourceModel\Game as GameResourceModel;
use Epam\ComputerGames\Model\GameFactory;
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
     * @param int $id
     * @return GameInterface
     * @throws NoSuchEntityException
     */
    public function get($id): GameInterface
    {
        $game = $this->gameFactory->create();
        $this->gameResourceModel->load($game, $id);
        if (!$game->getGameId()) {
            throw new NoSuchEntityException(
                __('There is no game with id %1', $id)
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
}
