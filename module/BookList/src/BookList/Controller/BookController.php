<?php
namespace BookList\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BookList\Form\BookForm;
use BookList\Model\Book;
use Zend\Mail;

class BookController extends AbstractActionController{
	protected $bookTable;
	
	public function indexAction() {
		$paginator = $this->getBookTable()->fetchAll(true);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(3);
		
        return new ViewModel(array(
            'paginator' => $paginator
        ));		
	}
	
	public function addAction() {
        $form = new BookForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $book = new Book();
            $form->setInputFilter($book->getInputFilter());
            $form->setData($request->getPost());

			if ($form->isValid()) {
                $book->exchangeArray($form->getData());
                $this->getBookTable()->saveBook($book);
				
				//email
			 	// $mail = new Mail\Message();
				// $mail->setBody('A new book called'.$book->title.' has been added.');
				// $mail->setFrom('zendcourse@gmail.com', 'Zend Course');
				// $mail->addTo('test@test.com', 'Dan');
				// $mail->setSubject('A Book was added');
				
				// $transport = new Mail\Transport\Sendmail();
				// $transport->send($mail);				
			}

            // Redirect to list of books
            return $this->redirect()->toRoute('book');
        }
        return array('form' => $form);		
	}
	
	public function editAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$book = $this->getBookTable()->getBook($id);
        $form  = new BookForm();
        $form->bind($book);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($book->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getBookTable()->saveBook($book);

                // Redirect to list of books
                return $this->redirect()->toRoute('book');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
		
	}
	
	public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('book');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getBookTable()->deleteBook($id);
            }

            // Redirect to list of books
            return $this->redirect()->toRoute('book');

        }

        return array(
            'id'    => $id,
            'book' => $this->getBookTable()->getBook($id) 
        );
	}
	
    public function getBookTable(){
        if (!$this->bookTable) {
            $sm = $this->getServiceLocator();
            $this->bookTable = $sm->get('BookList\Model\BookTable');
        }
        return $this->bookTable;
    }
	
}