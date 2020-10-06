<?php

namespace Product\Controller;

use Product\Form\ProductForm;
use Product\Model\Product;
use Product\Model\ProductTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
    private $table;

    // Add this constructor:
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
            return $this->redirect()->toRoute('order', ['action' => 'add']);

        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $order = $this->table->getOrder($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('order', ['action' => 'index']);
        }

        $form = new OrderForm();
        $form->bind($order);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($order->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveOrder($order);

        // Redirect to album list
        return $this->redirect()->toRoute('order', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('order');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteOrder($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('order');
        }

        return [
            'id'    => $id,
            'product' => $this->table->getProduct($id),
        ];
    }
}