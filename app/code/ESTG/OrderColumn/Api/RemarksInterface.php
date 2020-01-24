<?php
/**
 * Copyright © Gigadesign. All rights reserved.
 */
declare(strict_types=1);

namespace ESTG\OrderColumn\Api;

interface RemarksInterface
{

    /**
     * Get the remarks
     *
     * @return string
     */
    public function getRemarks();

    /**
     * Set the remarks
     *
     * @param string $remarks
     *
     * @return RemarksInterface
     */
    public function setRemarks(string $remarks);

}
