<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Formatter;

interface ProductMeasurementUnitFormatterInterface
{
    public function formatQuantityWithUnit(mixed $product, string $locale): ?string;

    public function isApplicableForProduct(mixed $product): bool;
}
