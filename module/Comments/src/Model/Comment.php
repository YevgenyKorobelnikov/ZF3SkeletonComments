<?php

/**
 * Class Comment 
 *
 * Представляет собой запись одного камментария
 *
 * File: Comment.php
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 */
 
namespace Comments\Model;
 
class Comment
{
    protected $data; 
 
    public function __get( $param ) 
    {
        return isset( $this->data[$param] ) ? $this->data[$param] : false;
    }    
    
    public function exchangeArray(array $data)
    {
        $this->data = $data;                    
    }
    
    public function toArray() {    
        return (array)$this->data;
    }
    
}