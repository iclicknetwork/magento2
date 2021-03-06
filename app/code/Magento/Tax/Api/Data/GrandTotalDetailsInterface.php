<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Tax\Api\Data;


interface GrandTotalDetailsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get tax amount value
     *
     * @return float|string
     */
    public function getAmount();

    /**
     * @param string|float $amount
     * @return $this
     */
    public function setAmount($amount);

    /**
     * Applied tax rates info
     *
     * @return \Magento\Tax\Api\Data\GrandTotalRatesInterface[]
     */
    public function getRates();

    /**
     * @param \Magento\Tax\Api\Data\GrandTotalRatesInterface[] $rates
     * @return $this
     */
    public function setRates($rates);

    /**
     * Details group identifier
     *
     * @return int
     */
    public function getGroupId();

    /**
     * @param int $id
     * @return $this
     */
    public function setGroupId($id);

    /**
     * {@inheritdoc}
     *
     * @return \Magento\Tax\Api\Data\GrandTotalDetailsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * {@inheritdoc}
     *
     * @param \Magento\Tax\Api\Data\GrandTotalDetailsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\Tax\Api\Data\GrandTotalDetailsExtensionInterface $extensionAttributes
    );
}
