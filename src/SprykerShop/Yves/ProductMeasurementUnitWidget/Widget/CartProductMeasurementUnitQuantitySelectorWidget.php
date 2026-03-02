<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Widget;

use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetFactory getFactory()
 */
class CartProductMeasurementUnitQuantitySelectorWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_ITEM_TRANSFER = 'itemTransfer';

    /**
     * @var string
     */
    protected const PARAMETER_QUANTITY_SALES_UNIT = 'quantitySalesUnit';

    /**
     * @var string
     */
    protected const PARAMETER_QUANTITY_SALES_UNIT_PRECISION = 'quantitySalesUnitPrecision';

    /**
     * @var string
     */
    protected const PARAMETER_NUMBER_FORMAT_CONFIG = 'numberFormatConfig';

    public function __construct(ItemTransfer $itemTransfer)
    {
        $this->addItemTransferParameter($itemTransfer);
        $this->addQuantitySalesUnitParameter($itemTransfer);
        $this->addQuantitySalesUnitPrecisionParameter($itemTransfer);
        $this->addNumberFormatConfigParameter();
    }

    public static function getName(): string
    {
        return 'CartProductMeasurementUnitQuantitySelectorWidget';
    }

    public static function getTemplate(): string
    {
        return '@ProductMeasurementUnitWidget/views/cart-product-measurement-unit-quantity-selector/cart-product-measurement-unit-quantity-selector.twig';
    }

    protected function addItemTransferParameter(ItemTransfer $itemTransfer): void
    {
        $this->addParameter(static::PARAMETER_ITEM_TRANSFER, $itemTransfer);
    }

    protected function addQuantitySalesUnitParameter(ItemTransfer $itemTransfer): void
    {
        $this->addParameter(static::PARAMETER_QUANTITY_SALES_UNIT, $itemTransfer->getQuantitySalesUnit());
    }

    protected function addQuantitySalesUnitPrecisionParameter(ItemTransfer $itemTransfer): void
    {
        $quantitySalesUnitPrecision = null;
        if ($itemTransfer->getQuantitySalesUnit() !== null) {
            $quantitySalesUnitPrecision = $itemTransfer->getQuantitySalesUnit()->getValue() / $itemTransfer->getQuantitySalesUnit()->getPrecision();
        }

        $this->addParameter(static::PARAMETER_QUANTITY_SALES_UNIT_PRECISION, $quantitySalesUnitPrecision);
    }

    protected function addNumberFormatConfigParameter(): void
    {
        $numberFormatConfigTransfer = $this->getFactory()
            ->getUtilNumberService()
            ->getNumberFormatConfig(
                $this->getFactory()->getLocaleClient()->getCurrentLocale(),
            );

        $this->addParameter(static::PARAMETER_NUMBER_FORMAT_CONFIG, $numberFormatConfigTransfer->toArray());
    }
}
