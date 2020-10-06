<?php

namespace Cporders\Controller;

use Cporders\Form\ProductForm;
use Cporders\Model\Product;
use Cporders\Model\ProductTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
    private $table;

    public function __construct(ProductTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'products' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ProductForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $product = new Product();
        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $product->exchangeArray($form->getData());
        $this->table->saveProduct($product);
        return $this->redirect()->toRoute('product');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('product', ['action' => 'add']);

        }

        // recupera el producto con el id proporcionado. Doing so raises
        // una excepción si es que el producto no se encuentra, el cual resulta en
        // redireccionar al usuario a la lista de productos
        try {
            $product = $this->table->getProduct($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }

        $form = new ProductForm();
        $form->bind($product);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['p_id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveProduct($product);

        return $this->redirect()->toRoute('product', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('p_id');
                $this->table->deleteProduct($id);
            }

            // Redirecciona a la lista de productos
            return $this->redirect()->toRoute('product');
        }

        return [
            'p_id'    => $id,
            'product' => $this->table->getProduct($id),
        ];
    }
}