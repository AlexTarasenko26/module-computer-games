<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Controller\Adminhtml\Game;

use Epam\ComputerGames\Model\GameFactory;
use Epam\ComputerGames\Model\ResourceModel\Game as GameResource;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends Action implements HttpPostActionInterface
{

    /**
     * Delete constructor.
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
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $gameId = (int)$this->getRequest()->getParam('game_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$gameId) {
            $this->messageManager->addErrorMessage(__('We can\'t find a game to delete'));
            return $resultRedirect->setPath('*/*/');
        }

        $model = $this->gameFactory->create();

        try {
            $this->resource->load($model, $gameId);
            $this->resource->delete($model);
            $this->messageManager->addSuccessMessage(__('The game has been deleted.'));
        } catch (\Throwable $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/');

    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Epam_ComputerGames::grid');
    }
}
