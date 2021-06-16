<?php

use \PHPUnit\Framework\TestCase;

class interfacesTest extends TestCase{
    
    
    public function testInterfaceCreateOrder(){

        require 'interface.php';

        $interface = new Interfacer("IPA", 10.00, 1);

        //mock order have 1 Weissbier and 2 "mock IPA" for a total of 79 DKK
    
        $ref= $interface -> create_order();

        //added 1 mock order with 1 "mock IPA" at 10DKK for a total of 89 DKK 
        
        $this -> assertEquals(89, $interface -> order_checkout());
        
        $this -> assertEquals('Beer', $ref);

        $this -> assertEquals($interface -> get_name(), "IPA");
        $this -> assertEquals($interface -> get_price(), 10.00);
        $this -> assertEquals($interface -> get_quantity(), 1);
        
        $order= new $ref ($interface -> get_name(), $interface -> get_price(), $interface -> get_quantity());

        $this -> assertEquals($interface -> get_name(), "IPA");
        $this -> assertEquals($interface -> get_price(), 10.00);
        $this -> assertEquals($interface -> get_quantity(), 1);
                       
        $rec= $interface -> order_recorder($order);

        //added 1 more mock order with 1 "mock IPA" at 10DKK for a total of 99 DKK  
        
        $this -> assertEquals(TRUE, $rec);

        $this -> assertEquals(99, $interface -> order_checkout());
    
    }



}