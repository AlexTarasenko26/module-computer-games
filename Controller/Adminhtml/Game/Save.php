<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Controller\Adminhtml\Game;

use Epam\ComputerGames\Model\GameFactory;
use Epam\ComputerGames\Model\ResourceModel\Game as GameResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param GameResource $resource
     * @param GameFactory $gameFactory
     */
    public function __construct(
        Context                       $context,
        private readonly GameResource $resource,
        private readonly GameFactory  $gameFactory
    )
    {
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $model = $this->gameFactory->create();
            if (empty($data['game_id'])) {
                $data['game_id'] = null;
            }
            $data['update_time'] = null;

            $model->setData($data);

            try {
                $this->resource->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the game.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $exception) {
                $this->messageManager->addExceptionMessage($exception);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the game.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
