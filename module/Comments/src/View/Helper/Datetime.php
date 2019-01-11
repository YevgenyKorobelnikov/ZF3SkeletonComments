<?php

/**
 * Class Datetime 
 *
 * Helper форматированного вывода даты
 *
 * File: Datetime.php
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 */
 

namespace Comments\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Zend\Stdlib\ErrorHandler;

class Datetime extends AbstractHelper 
{        
    /* по хорошему user Zend_Translate */
    protected $monthFormated = [
        "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"    
    ];

   /**
    * Convert numeric month to text equialent
    *
    * @param  string $month
    * @return string
    * @throws Exception if is not iset n [1..12]
    */
    
    protected function monthToString( $month ) {       
       $month = intval($month) - 1;       
                    
        if ( isset( $this->monthFormated[$month] ) )
            return $this->monthFormated[$month] ;
        throw new \Exception('Invalid numeric month Month must be in [1..12]: ' . $month);;    
    }
    
    public function format( string $datetime ) {                                      
        $year          = substr($datetime, 0,4);
        $month         = substr($datetime, 5,2);
        $day           = substr($datetime, 8,2);
        $hour          = substr($datetime, 11,2);
        $minutes       = substr($datetime, 14,2);
        $datetimeTime  = $hour . ":" . $minutes;
        
        return sprintf ("%s %s %s %s", $day, $this->monthToString($month), $year, $datetimeTime);        
    }
    
}