<?php
declare(strict_types=1);

namespace Epam\ComputerGames\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Image extends Column
{

    /**
     * UI component
     *
     * @var UiComponentInterface
     */
    protected $wrappedComponent;

    /**
     * Factory for UI Component
     *
     * @var UiComponentFactory
     */
    protected $uiComponentFactory;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        array              $components = [],
        array              $data = []
    )
    {
        $this->uiComponentFactory = $uiComponentFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
}
