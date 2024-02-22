<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Block\Adminhtml\Edit;

use Epam\ComputerGames\Api\GameRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /**
     * @param UrlInterface $url
     * @param Context $context
     * @param GameRepositoryInterface $gameRepository
     */
    public function __construct(
        private UrlInterface                     $url,
        private readonly Context                 $context,
        private readonly GameRepositoryInterface $gameRepository
    )
    {
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->url->getUrl($route, $params);
    }

    /**
     * @return int
     */
    public function getGameId()
    {
        $gameId = $this->context->getRequest()->getParam('game_id');
        try {
            return $this->gameRepository->getById($gameId)->getGameId();
        } catch (NoSuchEntityException $e) {
            $gameId = 0;

        }
        return $gameId;
    }
}
