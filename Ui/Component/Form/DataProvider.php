<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Form;

use Epam\ComputerGames\Model\Game;
use Epam\ComputerGames\Model\GameFactory;
use Epam\ComputerGames\Model\ResourceModel\Game as ResourceModel;
use Epam\ComputerGames\Model\ResourceModel\Game\CollectionFactory;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Filesystem\Driver\File\Mime;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\Pool;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var array
     */
    private array $loadedData;

    /**
     * @var ReadInterface
     */
    private ReadInterface $mediaDirectory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param GameFactory $gameFactory
     * @param ResourceModel $gameResource
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param StoreManagerInterface $storeManager
     * @param Mime $mime
     * @param array $meta
     * @param array $data
     * @param Pool|null $pool
     */
    public function __construct(
        CollectionFactory                 $collectionFactory,
        private readonly RequestInterface $request,
        Filesystem                        $filesystem,
        private readonly GameFactory      $gameFactory,
        private readonly ResourceModel    $gameResource,
                                          $name,
                                          $primaryFieldName,
                                          $requestFieldName,
        private StoreManagerInterface     $storeManager,
        private Mime                      $mime,
        array                             $meta = [],
        array                             $data = [],
        Pool                              $pool = null
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $collectionFactory->create();
        $this->mediaDirectory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
    }

    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $game = $this->getCurrentGame();
        $gameData = $game->getData();
        $image = $gameData['image'] ?? null;
        if (!$image) {
            $this->loadedData[$game->getId()] = $gameData;
            return $this->loadedData;
        } else {
            $gameData = $this->getImageData($image, $gameData);
        }

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

    /**
     * @param $image
     * @param array $gameData
     * @return array
     * @throws FileSystemException
     * @throws NoSuchEntityException
     */
    private function getImageData($image, array $gameData): array
    {
        $imgDir = 'games/upload';
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $fullImagePath = $this->mediaDirectory->getAbsolutePath($imgDir) . '/' . $image;
        $imageUrl = $baseUrl . $imgDir . '/' . $image;
        $stat = $this->mediaDirectory->stat($fullImagePath);

        $gameData['image'] = null;
        $gameData['image'][0]['url'] = $imageUrl;
        $gameData['image'][0]['name'] = $image;
        $gameData['image'][0]['size'] = $stat['size'];
        $gameData['image'][0]['type'] = $this->mime->getMimeType($fullImagePath);
        return $gameData;
    }
}
