<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget;

use Spryker\Yves\Kernel\AbstractBundleConfig;

class ProductMeasurementUnitWidgetConfig extends AbstractBundleConfig
{
    protected const int DEFAULT_MAX_FRACTION_DIGITS = 2;

    /**
     * Specification:
     * - Returns the maximum number of decimal places for displaying product quantity values.
     *
     * @api
     *
     * @return int
     */
    public function getMaxFractionDigits(): int
    {
        return static::DEFAULT_MAX_FRACTION_DIGITS;
    }
}
