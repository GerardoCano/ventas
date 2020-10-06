<?php

namespace Cporders\Controller;

use Cporders\Form\CustomerForm;
use Cporders\Model\Customer;
use Cporders\Model\CustomerTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class CustomerController extends AbstractActionController
{
    private $table;

    public function __construct(CustomerTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'customers' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new CustomerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $customer = new Customer();
        $form->setInputFilter($customer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $customer->exchangeArray($form->getData());
        $this->table->saveCustomer($customer);
        return $this->redirect()->toRoute('customer');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('customer', ['action' => 'add']);

        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $customer = $this->table->getCustomer($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('customer', ['action' => 'index']);
        }

        $form = new CustomerForm();
        $form->bind($customer);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($customer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveCustomer($customer);

        return $this->redirect()->toRoute('customer', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('customer');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCustomer($id);
            }

            // Redirect to list of customers
            return $this->redirect()->toRoute('customer');
        }

        return [
            'id'    => $id,
            'customer' => $this->table->getCustomer($id),
        ];
    }
}