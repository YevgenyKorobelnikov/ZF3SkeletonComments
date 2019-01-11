<?php
/**
 * Class CommentsController
 *
 * File: CommentsController.php
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 */

namespace Comments\Controller;

use Comments\Model\CommentsTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CommentsController extends AbstractActionController
{

    protected $commentsTable;
    
    public function __construct(CommentsTable $commentsTable)
    {
        $this->commentsTable = $commentsTable;
    }   

    public function indexAction()
    {    
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;        
    
        return new ViewModel( [
                'comments' => $this->commentsTable->getComments( 
                    ['page' => $page, 'itemCountPerPage' => 4] 
                ),
                'paginator' => $this->commentsTable->getPaginator()
            ]
        );
    }       
    
    public function addAction()    
    {
    
    }
}
