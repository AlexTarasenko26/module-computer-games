<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class GameActions extends Column
{

    /**
     * Url paths
     */
    const GAME_URL_PATH_EDIT = 'games/game/edit';
    const GAME_URL_PATH_DELETE = 'games/game/delete';
    /**
     * @var UrlBuilder
     */
    protected $actionUrlBuilder;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder         $actionUrlBuilder,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['game_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::GAME_URL_PATH_EDIT,
                            ['game_id' => $item['game_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::GAME_URL_PATH_DELETE, ['game_id' => $item['game_id']]),
                        'label' => __('Delete'), 'confirm' => [
                            'title' => __('Delete game'),
                            'message' => __('Are you sure you wan\'t to delete this record?')
                        ],
                        'post' => true
                    ];
                }
            }
        }
        return $dataSource;
    }
}
