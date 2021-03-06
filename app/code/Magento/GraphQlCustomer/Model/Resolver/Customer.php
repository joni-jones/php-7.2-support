<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\GraphQlCustomer\Model\Resolver;

use Magento\GraphQl\Model\ResolverInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\GraphQl\Model\ResolverContextInterface;

/**
 * Customers field resolver, used for GraphQL request processing.
 */
class Customer implements ResolverInterface
{
    /**
     * @var Customer\CustomerDataProvider
     */
    private $customerResolver;

    /**
     * @param \Magento\GraphQlCustomer\Model\Resolver\Customer\CustomerDataProvider $customerResolver
     */
    public function __construct(
        \Magento\GraphQlCustomer\Model\Resolver\Customer\CustomerDataProvider $customerResolver
    ) {
        $this->customerResolver = $customerResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $args, ResolverContextInterface $context)
    {
        if ((!$context->getUserId()) || $context->getUserType() == 4) {
            throw new GraphQlInputException(
                __('Current customer does not have access to the resource "%1"', 'customer')
            );
        }

        return $this->customerResolver->getCustomerById($context->getUserId());
    }
}
