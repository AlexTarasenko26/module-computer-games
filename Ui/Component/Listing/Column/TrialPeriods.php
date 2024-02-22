<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Listing\Column;

use Epam\ComputerGames\Api\GameRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TrialPeriods extends Column
{
    /**
     * @var GameRepositoryInterface
     */
    private GameRepositoryInterface $gameRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param GameRepositoryInterface $gameRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface        $context,
        UiComponentFactory      $uiComponentFactory,
        GameRepositoryInterface $gameRepository,
        array                   $components = [],
        array                   $data = []
    )
    {
        $this->gameRepository = $gameRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws \Exception
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $game = $this->gameRepository->getById((int)$item["game_id"]);
                $trialPeriod = $game->getData("trial_period");
                // Logic to retrieve data for the custom column
                switch ((int)$trialPeriod) {
                    case 0:
                        $item['trial_period'] = "Life time";
                        break;
                    case 1:
                        $item['trial_period'] = "Month";
                        break;
                    case 12:
                        $item['trial_period'] = "Year";
                        break;
                    default:
                        throw new \Exception('Unexpected value');
                }
            }
        }

        return $dataSource;
    }
}
