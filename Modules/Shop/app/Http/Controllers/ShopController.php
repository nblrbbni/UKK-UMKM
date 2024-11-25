<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

use Modules\Shop\Models\Products;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterface;

// use Modules\Shop\Models\Products;

class ShopController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    // protected $sortingQuery;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        parent::__construct();

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;

        $this->data['product_categories'] = $this->categoryRepository->findAll();

        // $this->sortingQuery = null;
        // $this->data['sortingQuery'] = $this->sortingQuery;
        // $this->data['sortingOptions'] = [
        //     '' => '-- Sort Products --',
        //     '?sort=price&order=asc' => 'Price: Low to High',
        //     '?sort=price&order=desc' => 'Price: High to Low',
        //     '?sort=publish_date&order=desc' => 'Newest Item',
        // ];

        // dd($this->data);
    }

    public function index()
    {
        $options = [
            'per_page' => $this->perPage,
        ];

        // if ($request->get('sort')) {
        //     $sort = $this->sortingRequest($request);
        //     $options['sort'] = $sort;

        //     $this->sortingQuery = '?sort=' . $sort['sort'] . '$order=' . $sort['order'];

        //     $this->data['sortingQuery'] = $this->sortingQuery;
        // }

        // $this->data['products'] = Products::paginate($this->perPage);
        $this->data['products'] = $this->productRepository->findAll($options);

        return $this->loadTheme('shop.index', $this->data);
    }

    public function category($categorySlug)
    {
        $category = $this->categoryRepository->findBySlug($categorySlug);

        $options = [
            'per_page' => $this->perPage,
            'filter' => [
                'category' => $categorySlug,
            ]
        ];

        $this->data['products'] = $this->productRepository->findAll($options);
        $this->data['category'] = $category;

        return $this->loadTheme('shop.category', $this->data);
    }

    public function show($categorySlug, $productSlug)
    {
        $product = $this->productRepository->findBySlug($productSlug);
        $category = $this->categoryRepository->findBySlug($categorySlug);

        $relatedProducts = Products::where('product_category_id', $product->product_category_id)
            ->where('id', '<>', $product->id)
            ->limit(4)
            ->get();

        $this->data['product'] = $product;
        $this->data['category'] = $category;
        $this->data['relatedProducts'] = $relatedProducts;

        return $this->loadTheme('shop.show', $this->data);
    }

    // function sortingRequest(Request $request)
    // {
    //     $sort = [];

    //     if ($request->get('sort') && $request->get('order')) {
    //         $sort = [
    //             'sort' => $request->get('sort'),
    //             'order' => $request->get('order')
    //         ];
    //     } else if ($request->get('sort')) {
    //         $sort = [
    //             'sort' => $request->get('sort'),
    //             'order' => 'desc'
    //         ];
    //     }

    //     return $sort;
    // }
}
