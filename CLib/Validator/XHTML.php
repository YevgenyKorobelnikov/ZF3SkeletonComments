<?php
namespace CLib\Validator;

class XHTML implements XHTML_Interface
{
  
    private function checkWellFormedTag( $tag ) {
        if (strpos($tag,"<",1)) {
            return false;
        }
        return preg_match("#(^<[a-z]|</[a-z])#si",$tag, $matches);
    }

    private function checkWellFormedAttribute( $attr ) {

    }


    private function normalize( $tag ) {
        if (preg_match("#([</a-z]+\s{0,1})#si", $tag, $matches)) {
            return $matches[1];
        }
        return false;
    }

    private function tagname($tag) {
        if (preg_match("#([a-z]+)#si", $tag, $matches)) {
            return $matches[1];
        }
        return false;
    }


    private function tagClosed( $tag ) {
        return strpos($tag, "</");
    }
    
    /**
    * Verify if HTML is valid
    *
    * @param string $text 
    * @return $array    
    * @throws Exception
    */                 
    public function valid( $text ) {
        $iLt   = 0;
        $iGt   = 0;   
        $stack = array();
        while ( true ) {

        	$iLt = strpos($text, '<', $iLt);
        	$iGt = strpos($text, '>', $iGt);        	
            
        	if ( $iGt < $iLt ) {            
        		  throw new \Exception("Content is not allowed in prolog");
        	} else if ( ($iLt + 1) == $iGt) {
        		  throw new \Exception("The markup in the document preceding the root element must be well-formed");
        	} else if ( $iLt === false && $iLt === false) {
        		break;
        	} else {
        		$tag = substr($text, $iLt, ($iGt - $iLt + 1));
        		
                if ( $this->checkWellFormedTag($tag) ) {
                    $tag     = $this->normalize($tag);
                    $tagname = $this->tagname($tag);
                    
                    /* verify tag opened */
                    if ( $this->tagClosed($tag) === false ) {            
                        array_push($stack, $tag);
                    } else {                
                       $tagOpened = $this->tagname(array_pop($stack));               
                       if ( $tagOpened != $tagname) {
                            throw new \Exception("End tag <{$tagname}> seen, but there were open elements at {$iLt}");
                       }
                    }
        		} else {
        			throw new \Exception("Invalid tag at position {$iLt}");
        		}
        	}

        	$iLt = $iGt;
        	$iGt++;
        }         
        return true;
    }    
}
