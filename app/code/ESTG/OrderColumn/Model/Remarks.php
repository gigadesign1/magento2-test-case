<?php
/**
 * Copyright © Gigadesign. All rights reserved.
 */
declare(strict_types=1);

namespace ESTG\OrderColumn\Model;

use ESTG\OrderColumn\Api\RemarksInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Model for oder remarks
 *
 * @author Mark van der Werf <ingo@gigadesign.nl>
 */
class Remarks extends AbstractModel implements RemarksInterface
{

    /**
     * @inheritDoc
     */
    public function getRemarks()
    {
        return $this->getData('remarks');
    }

    /**
     * @inheritDoc
     */
    public function setRemarks(string $remarks)
    {
        $this->setData('remarks', $remarks);

        return $this;
    }
}
