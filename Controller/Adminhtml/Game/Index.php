<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Controller\Adminhtml\Game;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    /**
     * ACL access restriction
     */
    const ADMIN_RESOURCE = 'Epam_ComputerGames::grid';

    public function execute()
    {
        $backendPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $backendPage->setActiveMenu('Epam_ComputerGames::grid');
        $backendPage->addBreadcrumb(__('Dashboard'), __('Games'));
        $backendPage->getConfig()->getTitle()->prepend(__('Games'));
        return $backendPage;
    }
}
