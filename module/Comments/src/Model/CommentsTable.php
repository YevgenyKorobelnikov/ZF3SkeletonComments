<?php

/**
 * Class CommentsController
 *
 * File: CommentsTable.php
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 */
 
namespace Comments\Model;
 
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
 
class CommentsTable
{
    protected $tableGateway;
    protected $paginator;
    protected $orderBy = "dt_added DESC";
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getPaginator( ) 
    {
        return isset ( $this->paginator ) ? $this->paginator : false;
    }    
    
    public function setOrder( $order ) 
    {
        $this->orderBy = $order;
    }    
	
    
    /**
    * Return tree comments 
    * 
    * @param mixed paginated
    * 
    * @return array()
    */
    public function getComments( $pagination = false)
    {
    
        /* получаем корневые узлы для пагинации */
        $select = new Select( $this->tableGateway->getTable() );
		$select->where('parent_id = 0')
            ->order( $this->orderBy );
         

        if ( !empty($pagination) && is_array($pagination) ) {        
            /* Create a new pagination adapter object: */
            $paginatorAdapter = new DbSelect( $select, $this->tableGateway->getAdapter() ); 
            $paginator        = new Paginator($paginatorAdapter);                    
            $paginator->setCurrentPageNumber( $pagination['page'] );         
            $paginator->setItemCountPerPage( $pagination['itemCountPerPage'] );
                    
            $result          = $paginator->getCurrentItems();            
            $this->paginator = $paginator;                
        
        } else {
            $result = $this->tableGateway->selectWith( $select )->toArray();
        }                
                		
        $ids      = [];
        $comments = [];
        foreach ( $result as $row ) {
            $ids[]                = $row['id'];            
            $comments[$row['id']] = $row ;
        }
                
        /* добираем дочерние узлы по root_id */
        $select = new Select( $this->tableGateway->getTable() );
        $select->where( ['root_id' => $ids] );                   
        $result = $this->tableGateway->selectWith( $select )->toArray();     
       
        foreach ( $result as $row ) {  
            $comments[$row['id']] = $row;
        }                               
                                  
        /* строим дерево */
        $tree = [];
        foreach( $comments as $id => & $row){                
            if( empty($row['parent_id']) ) {
	            $tree[$id] = & $row;                
	        } else {
	            $comments[$row['parent_id']]['childs'][$id] = & $row;                
	        }        
        }                       
                
        return $tree;
    }
 
    public function getComment($id)
    {
        $id     = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \Exception("Comment id={$id} does not exists");
        }
        return $row;
    }
 
    public function saveComment(Comment $comment)
    {
        $data = array(
            'id' =>        $comment->id,
            'parent_id' => $comment->parent_id,
            'username'  => $comment->username,
            'email'     => $comment->email,
            'text'      => $comment->text,
        );
 
        $id = (int)$comment->id;
        if ( $id == 0 ) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getComment($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception("Comment id={$id} does not exists");
            }
        }
    }
 
    public function deleteComment($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}