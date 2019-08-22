<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\ProductTable;
use Product\Model\Product;

class ProductController extends AbstractActionController
{
    private $productTable;
    private $product;

    public function __construct(
        ProductTable $productTable
    ) {
        $this->productTable = $productTable;
    }

    public function showAllProductsAction()
    {
        $products = $this->productTable->fetchAllProducts();
        $viewModel = new ViewModel([
            'products' => $products,
            'params' => $this->params()->fromQuery()
        ]);
        $viewModel->setTemplate('product/show-all-products');

        return $viewModel;
    }

    public function showProductAction()
    {
        $product_id = (int) $this->params()->fromRoute('id', 0);

        if (empty($product_id)) {
            return $this->redirect()->toRoute('product');
        }

        $product = $this->productTable->fetchProduct($product_id);
        
        if (empty($product)) {
            return $this->redirect()->toRoute('product');
        }
        
        $viewModel = new ViewModel([
            'product' => $product
        ]);
        $viewModel->setTemplate('product/show-product');

        return $viewModel;
    }
}