<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShopTest\Yves\ProductMeasurementUnitWidget\Plugin\AvailabilityWidget;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\BuyBoxProductTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductMeasurementBaseUnitTransfer;
use Generated\Shared\Transfer\ProductMeasurementSalesUnitTransfer;
use Generated\Shared\Transfer\ProductMeasurementUnitTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Dependency\Service\ProductMeasurementUnitWidgetToUtilNumberServiceInterface;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Plugin\AvailabilityWidget\ProductMeasurementUnitQuantityFormatterStrategyPlugin;
use SprykerShop\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetDependencyProvider;
use SprykerShopTest\Yves\ProductMeasurementUnitWidget\ProductMeasurementUnitWidgetYvesTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerShopTest
 * @group Yves
 * @group ProductMeasurementUnitWidget
 * @group Plugin
 * @group AvailabilityWidget
 * @group ProductMeasurementUnitQuantityFormatterStrategyPluginTest
 * Add your own group annotations below this line
 */
class ProductMeasurementUnitQuantityFormatterStrategyPluginTest extends Unit
{
    protected const string MEASUREMENT_UNIT_NAME = 'measurement_units.standard.weight.kilo.name';

    protected const float STOCK_QUANTITY = 10.5;

    protected const string LOCALE = 'en_US';

    protected const string FORMATTED_NUMBER = '10.5';

    protected const string TRANSLATED_UNIT = 'kg';

    protected ProductMeasurementUnitWidgetYvesTester $tester;

    protected GlossaryStorageClientInterface|MockObject $glossaryStorageClientMock;

    protected ProductMeasurementUnitWidgetToUtilNumberServiceInterface|MockObject $utilNumberServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->glossaryStorageClientMock = $this->createMock(GlossaryStorageClientInterface::class);
        $this->utilNumberServiceMock = $this->createMock(ProductMeasurementUnitWidgetToUtilNumberServiceInterface::class);

        $this->tester->setDependency(
            ProductMeasurementUnitWidgetDependencyProvider::CLIENT_GLOSSARY_STORAGE,
            $this->glossaryStorageClientMock,
        );
        $this->tester->setDependency(
            ProductMeasurementUnitWidgetDependencyProvider::SERVICE_UTIL_NUMBER,
            $this->utilNumberServiceMock,
        );
    }

    /**
     * @dataProvider isApplicableDataProvider
     */
    public function testGivenProductWhenCheckingApplicabilityThenReturnsCorrectResult(
        mixed $product,
        bool $expectedIsApplicable,
    ): void {
        // Arrange
        $plugin = new ProductMeasurementUnitQuantityFormatterStrategyPlugin();

        // Act
        $result = $plugin->isApplicable($product);

        // Assert
        $this->assertSame($expectedIsApplicable, $result);
    }

    /**
     * @dataProvider formatQuantityDataProvider
     */
    public function testGivenProductWhenFormattingQuantityThenReturnsExpectedResult(
        mixed $product,
        array $translationMap,
        ?string $expectedResult,
    ): void {
        // Arrange
        $this->utilNumberServiceMock
            ->method('formatFloat')
            ->willReturn(static::FORMATTED_NUMBER);

        $this->glossaryStorageClientMock
            ->method('translate')
            ->willReturnMap($translationMap);

        $plugin = new ProductMeasurementUnitQuantityFormatterStrategyPlugin();

        // Act
        $result = $plugin->formatQuantity($product, static::LOCALE);

        // Assert
        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array<string, mixed>
     */
    protected function formatQuantityDataProvider(): array
    {
        $shortKey = static::MEASUREMENT_UNIT_NAME . '.short';

        return [
            'ProductView with short translation uses short form' => [
                'product' => $this->createProductViewWithMeasurementUnit(),
                'translationMap' => [
                    [$shortKey, static::LOCALE, [], 'kg'],
                    [static::MEASUREMENT_UNIT_NAME, static::LOCALE, [], 'kilogram'],
                ],
                'expectedResult' => static::FORMATTED_NUMBER . ' kg',
            ],
            'ProductView without short translation falls back to long form' => [
                'product' => $this->createProductViewWithMeasurementUnit(),
                'translationMap' => [
                    [$shortKey, static::LOCALE, [], $shortKey],
                    [static::MEASUREMENT_UNIT_NAME, static::LOCALE, [], 'kilogram'],
                ],
                'expectedResult' => static::FORMATTED_NUMBER . ' kilogram',
            ],
            'BuyBoxProduct with untranslated unit returns translation key' => [
                'product' => $this->createBuyBoxProductWithMeasurementUnit(),
                'translationMap' => [
                    [$shortKey, static::LOCALE, [], $shortKey],
                    [static::MEASUREMENT_UNIT_NAME, static::LOCALE, [], static::MEASUREMENT_UNIT_NAME],
                ],
                'expectedResult' => static::FORMATTED_NUMBER . ' ' . static::MEASUREMENT_UNIT_NAME,
            ],
            'Item with short translation uses short form' => [
                'product' => $this->createItemWithMeasurementUnit(),
                'translationMap' => [
                    [$shortKey, static::LOCALE, [], 'kg'],
                    [static::MEASUREMENT_UNIT_NAME, static::LOCALE, [], 'kilogram'],
                ],
                'expectedResult' => static::FORMATTED_NUMBER . ' kg',
            ],
            'Item without short translation falls back to long form' => [
                'product' => $this->createItemWithMeasurementUnit(),
                'translationMap' => [
                    [$shortKey, static::LOCALE, [], $shortKey],
                    [static::MEASUREMENT_UNIT_NAME, static::LOCALE, [], 'kilogram'],
                ],
                'expectedResult' => static::FORMATTED_NUMBER . ' kilogram',
            ],
            'ProductView with baseUnit but empty name returns null' => [
                'product' => (new ProductViewTransfer())
                    ->setStockQuantity(static::STOCK_QUANTITY)
                    ->setBaseUnit(new ProductMeasurementUnitTransfer()),
                'translationMap' => [],
                'expectedResult' => null,
            ],
            'Item with measurement unit but null name returns null' => [
                'product' => (new ItemTransfer())
                    ->setStockQuantity(static::STOCK_QUANTITY)
                    ->setAmountSalesUnit(
                        (new ProductMeasurementSalesUnitTransfer())->setProductMeasurementBaseUnit(
                            (new ProductMeasurementBaseUnitTransfer())->setProductMeasurementUnit(
                                (new ProductMeasurementUnitTransfer())->setName(null),
                            ),
                        ),
                    ),
                'translationMap' => [],
                'expectedResult' => null,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function isApplicableDataProvider(): array
    {
        return [
            'ProductView with baseUnit returns true' => [
                'product' => $this->createProductViewWithMeasurementUnit(),
                'expectedIsApplicable' => true,
            ],
            'ProductView without baseUnit returns false' => [
                'product' => new ProductViewTransfer(),
                'expectedIsApplicable' => false,
            ],
            'Item with amountSalesUnit returns true' => [
                'product' => $this->createItemWithMeasurementUnit(),
                'expectedIsApplicable' => true,
            ],
            'Item without amountSalesUnit returns false' => [
                'product' => new ItemTransfer(),
                'expectedIsApplicable' => false,
            ],
            'Item with amountSalesUnit but no baseUnit returns false' => [
                'product' => (new ItemTransfer())->setAmountSalesUnit(new ProductMeasurementSalesUnitTransfer()),
                'expectedIsApplicable' => false,
            ],
            'ProductView with baseUnit but empty name returns false' => [
                'product' => (new ProductViewTransfer())->setBaseUnit(new ProductMeasurementUnitTransfer()),
                'expectedIsApplicable' => false,
            ],
            'Item with measurement unit but null name returns false' => [
                'product' => (new ItemTransfer())
                    ->setAmountSalesUnit(
                        (new ProductMeasurementSalesUnitTransfer())->setProductMeasurementBaseUnit(
                            (new ProductMeasurementBaseUnitTransfer())->setProductMeasurementUnit(
                                (new ProductMeasurementUnitTransfer())->setName(null),
                            ),
                        ),
                    ),
                'expectedIsApplicable' => false,
            ],
        ];
    }

    protected function createProductViewWithMeasurementUnit(): ProductViewTransfer
    {
        return (new ProductViewTransfer())
            ->setStockQuantity(static::STOCK_QUANTITY)
            ->setBaseUnit(
                (new ProductMeasurementUnitTransfer())->setName(static::MEASUREMENT_UNIT_NAME),
            );
    }

    protected function createBuyBoxProductWithMeasurementUnit(): BuyBoxProductTransfer
    {
        return (new BuyBoxProductTransfer())
            ->setStockQuantity(static::STOCK_QUANTITY)
            ->setBaseUnit(
                (new ProductMeasurementUnitTransfer())->setName(static::MEASUREMENT_UNIT_NAME),
            );
    }

    protected function createItemWithMeasurementUnit(): ItemTransfer
    {
        return (new ItemTransfer())
            ->setStockQuantity(static::STOCK_QUANTITY)
            ->setAmountSalesUnit(
                (new ProductMeasurementSalesUnitTransfer())->setProductMeasurementBaseUnit(
                    (new ProductMeasurementBaseUnitTransfer())->setProductMeasurementUnit(
                        (new ProductMeasurementUnitTransfer())->setName(static::MEASUREMENT_UNIT_NAME),
                    ),
                ),
            );
    }
}
