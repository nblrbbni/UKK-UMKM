<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

use Modules\Shop\Models\Customers;
use Modules\Shop\Models\OrderDetails;
use Modules\Shop\Models\Orders;
use Modules\Shop\Models\Products;

interface CartRepositoryInterface
{
    public function findByCustomer(Customers $customers): ?Orders;

    public function addProductToCart(Customers $customer, Products $product, $quantity): OrderDetails;

    public function updateOrderTotalAmount(Orders $order): void;

    public function removeItem($id): bool;

    public function updateQuantity(array $orderQuantities): void;
}
