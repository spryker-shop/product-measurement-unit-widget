<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductConcreteMeasurementUnitStorageTransfer;
use Generated\Shared\Transfer\ProductMeasurementUnitStorageTransfer;

class ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientBridge implements ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductMeasurementUnitStorage\ProductMeasurementUnitStorageClientInterface
     */
    protected $productMeasurementUnitStorageClient;

    /**
     * @param \Spryker\Client\ProductMeasurementUnitStorage\ProductMeasurementUnitStorageClientInterface $productMeasurementUnitStorageClient
     */
    public function __construct(
        $productMeasurementUnitStorageClient
    ) {
        $this->productMeasurementUnitStorageClient = $productMeasurementUnitStorageClient;
    }

    /**
     * @param int $idProductMeasurementUnit
     *
     * @return \Generated\Shared\Transfer\ProductMeasurementUnitStorageTransfer|null
     */
    public function findProductMeasurementUnitStorage(
        int $idProductMeasurementUnit
    ): ?ProductMeasurementUnitStorageTransfer {

        return $this->productMeasurementUnitStorageClient->findProductMeasurementUnitStorage($idProductMeasurementUnit);
    }

    /**
     * @param int $idProduct
     *
     * @return \Generated\Shared\Transfer\ProductConcreteMeasurementUnitStorageTransfer|null
     */
    public function findProductConcreteMeasurementUnitStorage(
        int $idProduct
    ): ?ProductConcreteMeasurementUnitStorageTransfer {
        return $this->productMeasurementUnitStorageClient->findProductConcreteMeasurementUnitStorage($idProduct);
    }
}
