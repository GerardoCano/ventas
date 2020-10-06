<?php

namespace Cporders\Controller;

use Cporders\Form\OrderForm;
use Cporders\Model\Order;
use Cporders\Model\OrderTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class OrderController extends AbstractActionController
{
    private $table;

    public function __construct(OrderTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'orders' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new OrderForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $order = new Order();
        $form->setInputFilter($order->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $order->exchangeArray($form->getData());
        $this->table->saveOrder($order);
        return $this->redirect()->toRoute('order');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('order', ['action' => 'add']);

        }

        // recupera el orden con el id proporcionado. Doing so raises
        // una excepción si es que el producto no se encuentra, el cual resulta en
        // redireccionar al usuario a la lista de ordenes
        try {
            $order = $this->table->getOrder($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('order', ['action' => 'index']);
        }

        $form = new OrderForm();
        $form->bind($order);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['p_id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($order->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveOrder($order);

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
                $id = (int) $request->getPost('p_id');
                $this->table->deleteOrder($id);
            }

            // Redirecciona a la lista de productos
            return $this->redirect()->toRoute('order');
        }

        return [
            'p_id'    => $id,
            'order' => $this->table->getOrder($id),
        ];
    }
}