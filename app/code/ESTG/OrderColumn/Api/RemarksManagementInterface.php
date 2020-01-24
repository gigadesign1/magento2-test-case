<?php
/**
 * Copyright © Gigadesign. All rights reserved.
 */
declare(strict_types=1);

namespace ESTG\OrderColumn\Api;

use Magento\Sales\Api\Data\OrderInterface;

interface RemarksManagementInterface
{

    /**
     * Edits remark of a specified order ID
     *
     * @param int $id The order ID.
     * @param RemarksInterface $remarks
     *
     * @return OrderInterface
     */
    public function edit($id, RemarksInterface $remarks);

}