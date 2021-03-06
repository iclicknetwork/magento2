<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Wishlist\Test\TestCase;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Product\CatalogProductView;
use Magento\Cms\Test\Page\CmsIndex;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\CustomerAccountIndex;
use Magento\Wishlist\Test\Page\WishlistIndex;
use Magento\Wishlist\Test\Page\WishlistShare;
use Magento\Mtf\Client\BrowserInterface;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Create Customer Account.
 * 2. Create product.
 *
 * Steps:
 * 1. Login to frontend as a Customer.
 * 2. Add product to Wish List.
 * 3. Click "Share Wish List" button.
 * 4. Fill in all data according to data set.
 * 5. Click "Share Wishlist" button.
 * 6. Perform all assertions.
 *
 * @group Wishlist_(CS)
 * @ZephyrId MAGETWO-23394
 */
class ShareWishlistEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'CS';
    const TO_MAINTAIN = 'yes';
    /* end tags */

    /**
     * Cms index page.
     *
     * @var CmsIndex
     */
    protected $cmsIndex;

    /**
     * Customer account index page.
     *
     * @var CustomerAccountIndex
     */
    protected $customerAccountIndex;

    /**
     * Product view page.
     *
     * @var CatalogProductView
     */
    protected $catalogProductView;

    /**
     * Wishlist index page.
     *
     * @var WishlistIndex
     */
    protected $wishlistIndex;

    /**
     * Wishlist share page.
     *
     * @var WishlistShare
     */
    protected $wishlistShare;

    /**
     * Prepare data.
     *
     * @param Customer $customer
     * @param CatalogProductSimple $product
     * @return array
     */
    public function __prepare(
        Customer $customer,
        CatalogProductSimple $product
    ) {
        $customer->persist();
        $product->persist();

        return [
            'customer' => $customer,
            'product' => $product
        ];
    }

    /**
     * Inject pages.
     *
     * @param CmsIndex $cmsIndex
     * @param CustomerAccountIndex $customerAccountIndex
     * @param CatalogProductView $catalogProductView
     * @param WishlistIndex $wishlistIndex
     * @param WishlistShare $wishlistShare
     * @return void
     */
    public function __inject(
        CmsIndex $cmsIndex,
        CustomerAccountIndex $customerAccountIndex,
        CatalogProductView $catalogProductView,
        WishlistIndex $wishlistIndex,
        WishlistShare $wishlistShare
    ) {
        $this->cmsIndex = $cmsIndex;
        $this->customerAccountIndex = $customerAccountIndex;
        $this->catalogProductView = $catalogProductView;
        $this->wishlistIndex = $wishlistIndex;
        $this->wishlistShare = $wishlistShare;
    }

    /**
     * Share wish list.
     *
     * @param BrowserInterface $browser
     * @param Customer $customer
     * @param CatalogProductSimple $product
     * @param array $sharingInfo
     * @return void
     */
    public function test(
        BrowserInterface $browser,
        Customer $customer,
        CatalogProductSimple $product,
        array $sharingInfo
    ) {
        //Steps
        $this->loginCustomer($customer);
        $browser->open($_ENV['app_frontend_url'] . $product->getUrlKey() . '.html');
        $this->catalogProductView->getViewBlock()->clickAddToWishlist();
        $this->wishlistIndex->getMessagesBlock()->waitSuccessMessage();
        $this->wishlistIndex->getWishlistBlock()->clickShareWishList();
        $this->cmsIndex->getCmsPageBlock()->waitPageInit();
        $this->wishlistShare->getSharingInfoForm()->fillForm($sharingInfo);
        $this->wishlistShare->getSharingInfoForm()->shareWishlist();
    }

    /**
     * Login customer.
     *
     * @param Customer $customer
     * @return void
     */
    protected function loginCustomer(Customer $customer)
    {
        $this->objectManager->create(
            'Magento\Customer\Test\TestStep\LoginCustomerOnFrontendStep',
            ['customer' => $customer]
        )->run();
    }
}
