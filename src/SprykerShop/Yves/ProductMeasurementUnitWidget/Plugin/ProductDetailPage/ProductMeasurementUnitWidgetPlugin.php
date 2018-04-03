<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Plugin\ProductDetailPage;

use Generated\Shared\Transfer\ProductMeasurementUnitTransfer;
use Generated\Shared\Transfer\ProductQuantityStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidgetPlugin;
use SprykerShop\Yves\ProductDetailPage\Dependency\Plugin\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetPluginInterface;

/**
 * @method \SprykerShop\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetFactory getFactory()
 */
class ProductMeasurementUnitWidgetPlugin extends AbstractWidgetPlugin implements ProductMeasurementUnitWidgetPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param array $qtyOptions
     *
     * @return void
     */
    public function initialize(ProductViewTransfer $productViewTransfer, array $qtyOptions = []): void
    {
        $salesUnits = null;
        $baseUnit = null;
        $productQuantityStorageTransfer = null;

        if ($productViewTransfer->getIdProductConcrete()) {
            $baseUnit = $this->getFactory()
                ->createProductMeasurementBaseUnitReader()
                ->findProductMeasurementBaseUnitByIdProductConcrete($productViewTransfer->getIdProductConcrete());

            $salesUnits = $this->getFactory()
                ->createProductMeasurementSalesUnitReader()
                ->findProductMeasurementSalesUnitByIdProductConcrete($productViewTransfer->getIdProductConcrete());

            $productQuantityStorageTransfer = $this->getFactory()
                ->getProductQuantityStorageClient()
                ->findProductQuantityStorage($productViewTransfer->getIdProductConcrete());
        }
        $minQuantityInBaseUnits = $this->getMinQuantityInBaseUnits($productQuantityStorageTransfer);
        $minQuantityInSalesUnits = $this->getMinQuantityInSalesUnits($salesUnits, $minQuantityInBaseUnits);

        $this
            ->addParameter('product', $productViewTransfer)
            ->addParameter('qtyOptions', $qtyOptions)
            ->addParameter('minQuantityInBaseUnits', $minQuantityInBaseUnits)
            ->addParameter('minQuantityInSalesUnits', $minQuantityInSalesUnits)
            ->addParameter('baseUnit', $baseUnit)
            ->addParameter('salesUnits', $salesUnits)
            ->addParameter('productQuantityStorage', $productQuantityStorageTransfer)
            ->addParameter(
                'jsonScheme',
                $this->prepareJsonData(
                    $baseUnit,
                    $salesUnits,
                    $productQuantityStorageTransfer
                )
            );
    }

    /**
     * @param \Generated\Shared\Transfer\ProductQuantityStorageTransfer|null $productQuantityStorageTransfer
     *
     * @return int
     */
    protected function getMinQuantityInBaseUnits(
        ProductQuantityStorageTransfer $productQuantityStorageTransfer = null
    ): int {
        $quantityMin = 1;
        if ($productQuantityStorageTransfer !== null) {
            $quantityMin = $productQuantityStorageTransfer->getQuantityMin() ?: 1;
        }

        return $quantityMin;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return string
     */
    public static function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return string
     */
    public static function getTemplate()
    {
        return '@ProductMeasurementUnitWidget/views/product-measurement-unit/product-measurement-unit.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\ProductMeasurementUnitTransfer|null $baseUnit
     * @param \Generated\Shared\Transfer\ProductMeasurementSalesUnitTransfer[]|null $salesUnits
     * @param \Generated\Shared\Transfer\ProductQuantityStorageTransfer|null $productQuantityStorageTransfer
     *
     * @return string
     */
    protected function prepareJsonData(
        ProductMeasurementUnitTransfer $baseUnit = null,
        array $salesUnits = null,
        ProductQuantityStorageTransfer $productQuantityStorageTransfer = null
    ): string {
        $jsonData = [];

        if ($baseUnit !== null) {
            $jsonData['baseUnit'] = $baseUnit->toArray();
        }

        if ($salesUnits !== null) {
            foreach ($salesUnits as $salesUnit) {
                $jsonData['salesUnits'][] = $salesUnit->toArray();
            }
        }

        if ($productQuantityStorageTransfer !== null) {
            $jsonData['productQuantityStorage'] = $productQuantityStorageTransfer->toArray();
        }

        return \json_encode($jsonData, true);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductMeasurementSalesUnitTransfer[]|null $salesUnits
     * @param int $minQuantityInBaseUnits
     *
     * @return float
     */
    protected function getMinQuantityInSalesUnits(array $salesUnits, int $minQuantityInBaseUnits): float
    {
        if ($salesUnits !== null) {
            foreach ($salesUnits as $salesUnit) {
                if ($salesUnit->getIsDefault()) {
                    $qtyInSalesUnits = $minQuantityInBaseUnits / $salesUnit->getConversion();

                    return round($qtyInSalesUnits, 3);
                }
            }
        }

        return $minQuantityInBaseUnits;
    }
}