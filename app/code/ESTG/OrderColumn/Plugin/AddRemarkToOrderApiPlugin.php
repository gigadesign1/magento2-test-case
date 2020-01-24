<?php
/**
 * Copyright © Gigadesign. All rights reserved.
 */
declare(strict_types=1);

namespace ESTG\OrderColumn\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface as Subject;

/**
 * Exposes the remark column to the rest api
 *
 * @author Mark van der Werf <ingo@gigadesign.nl>
 */
class AddRemarkToOrderApiPlugin
{

    const REMARK_COLUMN_NAME = 'remarks';

    /**
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param Subject $subject
     * @param OrderInterface $order
     *
     * @return OrderInterface
     */
    public function afterGet(Subject $subject, OrderInterface $order)
    {
        $remarks = $order->getData(self::REMARK_COLUMN_NAME);

        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setRemarks($remarks);

        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * @param Subject $subject
     * @param OrderSearchResultInterface $searchResult
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(Subject $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {
            $remarks = $order->getData(self::REMARK_COLUMN_NAME);

            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            $extensionAttributes->setRemarks($remarks);

            $order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }
}
