<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductQuantityStorageTransfer;

interface ProductMeasurementUnitWidgetToProductQuantityStorageClientInterface
{
    public function findProductQuantityStorage(int $idProduct): ?ProductQuantityStorageTransfer;
}
