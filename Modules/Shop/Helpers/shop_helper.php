<?php

if (!function_exists('shop_product_link')) {
    function shop_product_link($product)
    {
        $categorySlug = $product->product_category->slug ?? 'produk';

        $productSlug = $product->slug;

        return route('shop.show', [$categorySlug, $productSlug]);
    }
}

if (!function_exists('shop_category_link')) {
    function shop_category_link($category)
    {
        return route('shop.category', [$category->slug]);
    }
}
