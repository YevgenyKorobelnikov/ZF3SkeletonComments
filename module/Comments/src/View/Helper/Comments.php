<?php

/**
 * Class Comments 
 *
 * Helper для вывод камментов
 *
 * File: Comments.php
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 */
 

namespace Comments\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class Comments extends AbstractHelper 
{        
    
    public function render( array $comments ) {                              
        
        $view            = $this->getView();         
        $view->comments  = $comments;                        
        
        return $view->render("comments") ;
    }
    
}