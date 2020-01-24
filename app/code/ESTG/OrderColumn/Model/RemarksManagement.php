<?php
/**
 * Copyright © Gigadesign. All rights reserved.
 */
declare(strict_types=1);

namespace ESTG\OrderColumn\Model;

use ESTG\OrderColumn\Api\RemarksInterface;
use ESTG\OrderColumn\Api\RemarksManagementInterface;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Service to perform actions on order remarks
 *
 * @author Mark van der Werf <ingo@gigadesign.nl>
 */
class RemarksManagement implements RemarksManagementInterface
{

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderRepositoryInterface $orderRepository, OrderExtensionFactory $extensionFactory)
    {
        $this->orderRepository = $orderRepository;
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param $id
     * @param RemarksInterface $remarks
     *
     * @return OrderInterface
     */
    public function edit($id, RemarksInterface $remarks)
    {
        $order = $this->orderRepository->get($id);

        $order->setRemarks($remarks->getRemarks());

        $this->orderRepository->save($order);

        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setRemarks($order->getRemarks());

        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }
}
