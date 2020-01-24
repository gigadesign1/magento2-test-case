<?php
/**
 * Copyright © Gigadesign. All rights reserved.
 */
declare(strict_types=1);

namespace ESTG\StockNotice\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\InventoryApi\Api\GetSourceItemsBySkuInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Widget\Block\BlockInterface;

/**
 * Block for displaying product stock notice
 *
 * @author Mark van der Werf <info@gigadesign.nl>
 */
class StockNotice extends Template implements BlockInterface, IdentityInterface
{

    const XML_PATH_STOCK_NOTICE_MINIMAL_LEVEL = 'cataloginventory/stock_notice/stock_level';

    /**
     * @var GetSourceItemsBySkuInterface
     */
    protected $getSourceItemsBySku;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param GetSourceItemsBySkuInterface $getSourceItemsBySku
     * @param ScopeConfigInterface $scopeConfig
     * @param Registry $registry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        GetSourceItemsBySkuInterface $getSourceItemsBySku,
        ScopeConfigInterface $scopeConfig,
        Registry $registry,
        Context $context,
        array $data = []
    ) {
        $this->getSourceItemsBySku = $getSourceItemsBySku;
        $this->scopeConfig = $scopeConfig;
        $this->registry = $registry;

        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    public function getMinimalStockForNotice(): int
    {
        return (int) $this->scopeConfig->getValue(self::XML_PATH_STOCK_NOTICE_MINIMAL_LEVEL, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the current stock level over all sources for current product
     *
     * @return float
     */
    public function getCurrentStock(): float
    {
        $currentStock = (float) 0;

        $sourceItems = $this->getSourceItemsBySku->execute(
            $this->getProduct()->getSku()
        );

        foreach ($sourceItems as $sourceItem) {
            $currentStock+= (float) $sourceItem->getQuantity();
        }

        return $currentStock;
    }


    /**
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->registry->registry('product');
    }

    /**
     * Return identifiers for product
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = $this->getProduct()->getIdentities();

        return $identities;
    }
}
