<?php

namespace Album\Controller;

use Album\Model\AlbumTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Album\Form\AlbumForm;
use Album\Model\Album;

class AlbumController extends AbstractActionController
{

    private $table;

    //Este constructor permite que nuestro controlador dependa de Albumtable
    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }

    //Devuelve una instancia ViewModel con una matriz que contiene los datos de los albumes
    public function indexAction()
    {
        return new ViewModel([
            'albums' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {   
        //Se crea una instancia AlbumForm y se etiqueta el botón de enviar como un add, esto es para poder reutilizar el formulario
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        //Si la solicitud no es de tipo POST no se van a enviar los datos y se volverá a mostrar el formulario
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        //Se crea una instancia y pasamos los datos del formulario por el filtro
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        //Si la validacion falla se volvera a mostrar el formulario con la información de que campos fallaron y por qué
        if (! $form->isValid()) {
            return ['form' => $form];
        }

        //Si la informacion enviada es valida se almcenan los datos del formulario en el modelo saveAlbum()
        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        //Una vez guardados los datos redireccionamos a la lista de albumes
        return $this->redirect()->toRoute('album');
    }

    public function editAction()
    {
        //Busca el id del album que se desea editar
        $id = (int) $this->params()->fromRoute('id', 0);

        //Si id es 0 redirigimos a AGREGAR
        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        // Recupera el álbum con el id especificado
        // arrojando una excepción si no se encuentra,
        // redireccionando a la lista de albumes
        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        //Guardar los cambios hecho al album
        $this->table->saveAlbum($album);

        // Redireccionar a la lista de albumes
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    public function deleteAction()
    {   

        //Obtenemos el id del album que se desea eliminar
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        //Verificamos que la solicitud sea de tipo POST para determinar si se muestra una confiramción o se elimina el album
        $request = $this->getRequest();
        if ($request->isPost()) {
            //Hacemos la confirmacion, si la respuesta es sí, se elimina, si es no, se cancela el proceso
            $del = $request->getPost('del', 'No');

            if ($del == 'Si') {
                $id = (int) $request->getPost('id');
                //Se usa un objeto de la tabla para eliminar la fila con el metodo deleteAlbum()
                $this->table->deleteAlbum($id);
            }

            //Redirecciona a la lista de albumes
            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->table->getAlbum($id),
        ];
    }
}