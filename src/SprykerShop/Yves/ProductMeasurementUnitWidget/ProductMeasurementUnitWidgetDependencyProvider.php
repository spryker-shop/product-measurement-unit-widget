<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductMeasurementUnitWidget;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client\ProductMeasurementUnitWidgetToLocaleClientBridge;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client\ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientBridge;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Client\ProductMeasurementUnitWidgetToProductQuantityStorageClientBridge;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service\ProductMeasurementUnitWidgetToUtilEncodingServiceBridge;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service\ProductMeasurementUnitWidgetToUtilNumberServiceBridge;

class ProductMeasurementUnitWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE = 'CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_PRODUCT_QUANTITY_STORAGE = 'CLIENT_PRODUCT_QUANTITY_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_LOCALE = 'CLIENT_LOCALE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const SERVICE_UTIL_NUMBER = 'SERVICE_UTIL_NUMBER';

    public const string CLIENT_GLOSSARY_STORAGE = 'CLIENT_GLOSSARY_STORAGE';

    public function provideDependencies(Container $container): Container
    {
        $container = $this->addProductMeasurementUnitStorageClient($container);
        $container = $this->addProductQuantityStorageClient($container);
        $container = $this->addLocaleClient($container);
        $container = $this->addUtilEncodingService($container);
        $container = $this->addUtilNumberService($container);
        $container = $this->addGlossaryStorageClient($container);

        return $container;
    }

    protected function addProductMeasurementUnitStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE, function (Container $container) {
            return new ProductMeasurementUnitWidgetToProductMeasurementUnitStorageClientBridge(
                $container->getLocator()->productMeasurementUnitStorage()->client(),
            );
        });

        return $container;
    }

    protected function addProductQuantityStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_QUANTITY_STORAGE, function (Container $container) {
            return new ProductMeasurementUnitWidgetToProductQuantityStorageClientBridge(
                $container->getLocator()->productQuantityStorage()->client(),
            );
        });

        return $container;
    }

    protected function addLocaleClient(Container $container): Container
    {
        $container->set(static::CLIENT_LOCALE, function (Container $container) {
            return new ProductMeasurementUnitWidgetToLocaleClientBridge(
                $container->getLocator()->locale()->client(),
            );
        });

        return $container;
    }

    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new ProductMeasurementUnitWidgetToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service(),
            );
        });

        return $container;
    }

    protected function addUtilNumberService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_NUMBER, function (Container $container) {
            return new ProductMeasurementUnitWidgetToUtilNumberServiceBridge(
                $container->getLocator()->utilNumber()->service(),
            );
        });

        return $container;
    }

    protected function addGlossaryStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_GLOSSARY_STORAGE, function (Container $container) {
            return $container->getLocator()->glossaryStorage()->client();
        });

        return $container;
    }
}
