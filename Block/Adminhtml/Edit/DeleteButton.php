<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Block\Adminhtml\Edit;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getGameId()) {
            $data = [
                'label' => __('Delete Game'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['game_id' => $this->getGameId()]);
    }
}
