<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductConcreteMeasurementUnitStorageTransfer;
use Generated\Shared\Transfer\ProductMeasurementUnitStorageTransfer;
use Generated\Shared\Transfer\ProductMeasurementUnitTransfer;

interface ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientInterface
{
    public function findProductMeasurementUnitStorage(
        int $idProductMeasurementUnit
    ): ?ProductMeasurementUnitStorageTransfer;

    public function findProductConcreteMeasurementUnitStorage(
        int $idProduct
    ): ?ProductConcreteMeasurementUnitStorageTransfer;

    /**
     * @param int $idProductConcrete
     *
     * @return array<\Generated\Shared\Transfer\ProductMeasurementSalesUnitTransfer>|null
     */
    public function findProductMeasurementSalesUnitByIdProductConcrete(int $idProductConcrete): ?array;

    public function findProductMeasurementBaseUnitByIdProductConcrete(int $idProductConcrete): ?ProductMeasurementUnitTransfer;
}
