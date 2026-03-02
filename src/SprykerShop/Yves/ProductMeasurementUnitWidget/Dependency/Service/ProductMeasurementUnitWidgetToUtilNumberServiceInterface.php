<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service;

use Generated\Shared\Transfer\NumberFormatConfigTransfer;
use Generated\Shared\Transfer\NumberFormatFloatRequestTransfer;

interface ProductMeasurementUnitWidgetToUtilNumberServiceInterface
{
    public function getNumberFormatConfig(?string $locale = null): NumberFormatConfigTransfer;

    public function formatFloat(NumberFormatFloatRequestTransfer $numberFormatFloatRequestTransfer): string;
}
