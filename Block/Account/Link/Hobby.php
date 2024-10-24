<?php

declare(strict_types=1);

namespace Nakor\TestTask\Block\Account\Link;

use Magento\Customer\Block\Account\SortLinkInterface;
use Magento\Framework\View\Element\Html\Link;

class Hobby extends Link implements SortLinkInterface
{
    /**
     * @inheritdoc
     */
    public function getHref(): string
    {
        return $this->getUrl('testtask/hobby/edit');
    }

    /**
     * @inheritdoc
     */
    public function getSortOrder(): int
    {
        return (int) $this->getData(self::SORT_ORDER);
    }
}
