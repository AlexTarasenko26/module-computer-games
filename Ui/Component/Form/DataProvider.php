<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Form;

use Epam\ComputerGames\Model\Game;
use Epam\ComputerGames\Model\GameFactory;
use Epam\ComputerGames\Model\ResourceModel\Game as ResourceModel;
use Epam\ComputerGames\Model\ResourceModel\Game\CollectionFactory;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var array
     */
    private $loadedData;

    /**
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param GameFactory $gameFactory
     * @param ResourceModel $gameResource
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        private readonly RequestInterface $request,
        private readonly GameFactory      $gameFactory,
        private readonly ResourceModel    $gameResource,
                                          $name,
                                          $primaryFieldName,
                                          $requestFieldName,
        array                             $meta = [],
        array                             $data = [],
        PoolInterface                     $pool = null
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $collectionFactory->create();
    }

    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $game = $this->getCurrentGame();
        $gameData = $game->getData();

        $this->loadedData[$game->getId()] = $gameData;

        return $this->loadedData;
    }


    /**
     * @return Game
     */
    private function getCurrentGame(): Game
    {
        $gameId = $this->getGameId();
        $game = $this->gameFactory->create();
        if (!$gameId) {
            return $game;
        }

        $this->gameResource->load($game, $gameId);

        return $game;
    }

    /**
     * @return int
     */
    private function getGameId(): int
    {
        return (int)$this->request->getParam($this->getRequestFieldName());
    }
}
