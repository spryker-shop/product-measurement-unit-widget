<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Plugin\AvailabilityWidget;

use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\AvailabilityWidgetExtension\Dependency\Plugin\AvailabilityQuantityFormatterStrategyPluginInterface;

/**
 * @method \SprykerShop\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetFactory getFactory()
 */
class ProductMeasurementUnitQuantityFormatterStrategyPlugin extends AbstractPlugin implements AvailabilityQuantityFormatterStrategyPluginInterface
{
    /**
     * {@inheritDoc}
     * - Checks if the product has a measurement unit configured.
     * - Returns true if the product is either a `ProductViewTransfer` or `BuyBoxProductTransfer` with base unit or an `ItemTransfer` with amount sales unit.
     *
     * @api
     *
     * @param mixed $product
     *
     * @return bool
     */
    public function isApplicable(mixed $product): bool
    {
        return $this->getFactory()
            ->createProductMeasurementUnitFormatter()
            ->isApplicableForProduct($product);
    }

    /**
     * {@inheritDoc}
     * - Formats the product stock quantity with its measurement unit.
     * - Uses the provided locale for number formatting.
     * - Returns null if the product has no measurement unit.
     *
     * @api
     *
     * @param mixed $product
     * @param string $locale
     *
     * @return string|null
     */
    public function formatQuantity(mixed $product, string $locale): ?string
    {
        return $this->getFactory()
            ->createProductMeasurementUnitFormatter()
            ->formatQuantityWithUnit($product, $locale);
    }
}
