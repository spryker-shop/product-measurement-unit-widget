<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget;

use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client\ProductMeasurementUnitWidgetToLocaleClientInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client\ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client\ProductMeasurementUnitWidgetToProductQuantityStorageClientInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service\ProductMeasurementUnitWidgetToUtilEncodingServiceInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service\ProductMeasurementUnitWidgetToUtilNumberServiceInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Formatter\ProductMeasurementUnitFormatter;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Formatter\ProductMeasurementUnitFormatterInterface;

/**
 * @method \SprykerShop\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetConfig getConfig()
 */
class ProductMeasurementUnitWidgetFactory extends AbstractFactory
{
    public function createProductMeasurementUnitFormatter(): ProductMeasurementUnitFormatterInterface
    {
        return new ProductMeasurementUnitFormatter(
            $this->getUtilNumberService(),
            $this->getGlossaryStorageClient(),
            $this->getConfig(),
        );
    }

    public function getProductMeasurementUnitStorageClient(): ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientInterface
    {
        return $this->getProvidedDependency(ProductMeasurementUnitWidgetDependencyProvider::CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE);
    }

    public function getProductQuantityStorageClient(): ProductMeasurementUnitWidgetToProductQuantityStorageClientInterface
    {
        return $this->getProvidedDependency(ProductMeasurementUnitWidgetDependencyProvider::CLIENT_PRODUCT_QUANTITY_STORAGE);
    }

    public function getUtilEncodingService(): ProductMeasurementUnitWidgetToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(ProductMeasurementUnitWidgetDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    public function getLocaleClient(): ProductMeasurementUnitWidgetToLocaleClientInterface
    {
        return $this->getProvidedDependency(ProductMeasurementUnitWidgetDependencyProvider::CLIENT_LOCALE);
    }

    public function getUtilNumberService(): ProductMeasurementUnitWidgetToUtilNumberServiceInterface
    {
        return $this->getProvidedDependency(ProductMeasurementUnitWidgetDependencyProvider::SERVICE_UTIL_NUMBER);
    }

    public function getGlossaryStorageClient(): GlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(ProductMeasurementUnitWidgetDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }
}
