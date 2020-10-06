<?php

namespace Cporders\Controller;

use Cporders\Form\SupplierForm;
use Cporders\Model\Supplier;
use Cporders\Model\SupplierTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SupplierController extends AbstractActionController
{
    private $table;

    // Add this constructor:
    public function __construct(SupplierTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'suppliers' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new SupplierForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $supplier = new Supplier();
        $form->setInputFilter($supplier->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $supplier->exchangeArray($form->getData());
        $this->table->saveSupplier($supplier);
        return $this->redirect()->toRoute('supplier');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('supplier', ['action' => 'add']);

        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $supplier = $this->table->getSupplier($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('supplier', ['action' => 'index']);
        }

        $form = new SupplierForm();
        $form->bind($supplier);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($supplier->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveSupplier($supplier);

        // Redirect to album list
        return $this->redirect()->toRoute('supplier', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('supplier');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteSupplier($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('supplier');
        }

        return [
            'id'    => $id,
            'supplier' => $this->table->getSupplier($id),
        ];
    }
}