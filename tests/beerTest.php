<?php

use \PHPUnit\Framework\TestCase;

class beerTest extends TestCase{
    
    
    public function testCreationBeer(){

        require 'beer.php';

        $beer = new Beer("Tester", 10.00, 1);
    
        $this -> assertEquals('FALSE,FALSE,FALSE', $beer -> set_price(20.00));
        
        $this -> assertEquals(20.00, $beer -> get_price());
        
        $this -> assertEquals('FALSE,FALSE,FALSE', $beer -> set_beer('test'));
        
        $this -> assertEquals('test', $beer -> get_beer());
        
        $this -> assertEquals('FALSE,FALSE,FALSE', $beer -> set_quantity('2'));
        
        $this -> assertEquals('2', $beer -> get_quantity()); 
    }



}