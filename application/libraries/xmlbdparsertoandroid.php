<?php if(!defined('BASEPATH'))         exit('No direct script access allowed');


class Xmlbdparsertoandroid extends DOMDocument{
    
    function  __construct()
    {
            parent::__construct('1.0', 'utf-8');       
    }

    
      public function fromMixed($mixed, $start=true,DOMElement $domElement = null) {
        
        if($start){
            $domElement = is_null($domElement) ? $this : $domElement;
            $domElement=$domElement->appendChild($this->createElement("sqlResponse"));
        }
        if (is_array($mixed)) {
            foreach( $mixed as $index => $value ) {
                 
                
                        if(is_array($value) && count($value)>=1)
                        {
                            $node = $this->createElement($index);
                            $dm=$domElement->appendChild($node);
                            if(isset($value['attribute']))
                            {
                                $attr=$value['attribute'];
                                foreach($attr as $name=>$val)
                                {
                                    $domAttribute = $this->createAttribute($name);
                                    $domAttribute->value = $val;
                                    $dm->appendChild($domAttribute);
                                }
                            }else
                            {
                                $this->fromMixed($value,false,$dm);
                            }
                            
                        }else
                        {
                                $node = $this->createElement($index,$value);
                                $domElement->appendChild($node);
                            
                        }

            }
        }
         
    }
    //put your code here
}
