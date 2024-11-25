<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

interface ProductRepositoryInterface
{
    public function findAll($options = []);
    public function findBySlug($productSlug);
    public function findByID($id);
}
