<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Form;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ImageUploader;

class ImageModifier implements ModifierInterface
{
    protected StoreManagerInterface $storeManager;
    protected ImageUploader $imageUploader;

    public function __construct(
        StoreManagerInterface $storeManager,
        ImageUploader         $imageUploader
    )
    {
        $this->storeManager = $storeManager;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @param array $data
     * @return array
     * @throws NoSuchEntityException
     */
    public function modifyData(array $data)
    {
        foreach ($data as $image) {
            $imageData = $image->getData();
            if (isset($imageData['image'])) {
                $arrayImageData = [];
                $arrayImageData[0]['name'] = 'Image';
                $arrayImageData[0]['url'] = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $this->imageUploader->getFilePath(
                        $this->imageUploader->getBasePath(),
                        $image->getImage()
                    );
                $imageData['image'] = $arrayImageData;
            }
            $image->setData($imageData);
            $data[$image->getId()] = $imageData;
        }
        return $data;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
