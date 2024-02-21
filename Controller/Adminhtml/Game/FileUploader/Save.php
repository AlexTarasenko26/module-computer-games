<?php

declare(strict_types=1);

namespace Epam\ComputerGames\Controller\Adminhtml\Game\FileUploader;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Catalog\Model\ImageUploader;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Action implements HttpPostActionInterface
{
    private WriteInterface $mediaDirectory;

    /**
     * @param Context $context
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context                                $context,
        Filesystem                             $filesystem,
        private readonly StoreManagerInterface $storeManager,
        private readonly ImageUploader         $imageUploader,
        private readonly UploaderFactory       $uploaderFactory
    )
    {
        parent::__construct($context);
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $fileUploader = $this->uploaderFactory->create(['fileId' => 'image']);
            $fileUploader->setAllowedExtensions($this->imageUploader->getAllowedExtensions());
            $fileUploader->setAllowRenameFiles(true);
            $fileUploader->setAllowCreateFolders(true);
            $fileUploader->setFilesDispersion(false);
            $imgPath = $this->imageUploader->getBaseTmpPath();

            $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath($imgPath));
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $fileName = ltrim(str_replace('\\', '/', $result['file']), '/');
            $result['url'] = $mediaUrl . $imgPath . '/' . $fileName;

            return $jsonResult->setData($result);
        } catch (LocalizedException $exception) {
            return $jsonResult->setData(['errorcode' => 0, 'error' => $exception->getMessage()]);
        } catch (\Exception $e) {
            return $jsonResult->setData(
                ['errorcode' => 0, 'error' => __('An error occurred, please try again later.')]
            );
        }
    }
}
