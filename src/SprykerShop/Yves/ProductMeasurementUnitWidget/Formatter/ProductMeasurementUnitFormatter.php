<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget\Formatter;

use Generated\Shared\Transfer\BuyBoxProductTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\NumberFormatFilterTransfer;
use Generated\Shared\Transfer\NumberFormatFloatRequestTransfer;
use Generated\Shared\Transfer\ProductMeasurementUnitTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service\ProductMeasurementUnitWidgetToUtilNumberServiceInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetConfig;

class ProductMeasurementUnitFormatter implements ProductMeasurementUnitFormatterInterface
{
    protected const string UNIT_NAME_SHORT_TEMPLATE = '%s.short';

    public function __construct(
        protected ProductMeasurementUnitWidgetToUtilNumberServiceInterface $utilNumberService,
        protected GlossaryStorageClientInterface $glossaryStorageClient,
        protected ProductMeasurementUnitWidgetConfig $config,
    ) {
    }

    public function formatQuantityWithUnit(mixed $product, string $locale): ?string
    {
        $measurementUnit = $this->extractMeasurementUnitFromProduct($product);

        if ($measurementUnit === null) {
            return null;
        }

        $formattedNumber = $this->formatNumber($product->getStockQuantity(), $locale);
        $translatedUnit = $this->translateUnit($measurementUnit->getNameOrFail(), $locale);

        return sprintf('%s %s', $formattedNumber, $translatedUnit);
    }

    public function isApplicableForProduct(mixed $product): bool
    {
        return $this->extractMeasurementUnitFromProduct($product) !== null;
    }

    protected function formatNumber(float $quantity, string $locale): string
    {
        $numberFormatFloatRequestTransfer = (new NumberFormatFloatRequestTransfer())
            ->setNumber($quantity)
            ->setNumberFormatFilter(
                (new NumberFormatFilterTransfer())
                    ->setLocale($locale)
                    ->setMaxFractionDigits($this->config->getMaxFractionDigits()),
            );

        return $this->utilNumberService->formatFloat($numberFormatFloatRequestTransfer);
    }

    protected function translateUnit(string $unitName, string $locale): string
    {
        $shortUnitKey = sprintf(static::UNIT_NAME_SHORT_TEMPLATE, $unitName);
        $translatedShortUnit = $this->glossaryStorageClient->translate($shortUnitKey, $locale);

        if ($translatedShortUnit !== $shortUnitKey) {
            return $translatedShortUnit;
        }

        return $this->glossaryStorageClient->translate($unitName, $locale);
    }

    protected function extractMeasurementUnitFromProduct(mixed $product): ?ProductMeasurementUnitTransfer
    {
        $measurementUnit = null;

        if ($product instanceof ProductViewTransfer || $product instanceof BuyBoxProductTransfer) {
            $measurementUnit = $product->getBaseUnit();
        }

        if ($product instanceof ItemTransfer) {
            $measurementUnit = $product->getAmountSalesUnit()?->getProductMeasurementBaseUnit()?->getProductMeasurementUnit();
        }

        if ($measurementUnit === null || !$measurementUnit->getName()) {
            return null;
        }

        return $measurementUnit;
    }
}
