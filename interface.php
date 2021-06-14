<?php

require_once("beer.php");

class Interfacer{
    
private $name= '';
private $price= 0.0;
private $quantity= 0;

function __construct($temp_n,$temp_p,$temp_q){

    $this -> name= $temp_n;
    $this -> price= $temp_p;    
    $this -> quantity= $temp_q;    
}

function create_order(){
    
    $menu = file_get_contents('data/tap_offers.json');
    $json = json_decode($menu, true);
    $ref = '';
    
    foreach ($json as $key => $value) {
        
        foreach ($value as $key => $val) {                      
            
            $ref= $key;          
            
                foreach ($val as $key1 => $val1) { 
                
                    foreach ($val1 as $key2 => $val2) {
                                
                    if ($val2 == $this -> name){
                
                    break 4;
                    }                      
                }                
            }
        }
    }
   
    $order= new $ref ($this -> name, $this -> price, $this -> quantity);
  
    if (!file_exists('data/history.xml') ){
        
        $this -> order_recorder_init($order);
    }
    else{
       
        $this -> order_recorder($order);
    }    
    
    return $ref;
}

function order_recorder_init($rec_ord){

    try {
        $xmlDoc = new DOMDocument('1.0', 'utf-8');    
                
        $file_handle = fopen("data/history.xml", "w") or die("Unable to open file!");
        fclose($file_handle);
    
        $xmlDoc -> load('data/history.xml'); 
        $create_node_h = $xmlDoc -> createElement ("history");
        $xmlDoc -> appendChild($create_node_h);
        $create_node_o = $xmlDoc -> createElement ("order");
        $create_node_h -> appendChild($create_node_o);
        $element_t = $xmlDoc -> createElement ("type", $rec_ord -> get_beer());
        $create_node_o -> appendChild($element_t);        
        $element_q = $xmlDoc -> createElement ("quantity", $rec_ord -> get_quantity());
        $create_node_o -> appendChild($element_q);
        $element_p = $xmlDoc -> createElement ("price", $rec_ord -> get_price());
        $create_node_o -> appendChild($element_p);          
                   
        $xmlDoc->saveXML();
        $xmlDoc->save("data/history.xml");
        }
        catch(Exception $e){
            echo "Error: please reload application";
        }
    
     return file_exists('data/history.xml');
}

function order_recorder($rec_ord){
    
    try {
    $history = simplexml_load_file('data/history.xml');

    $child = $history -> addChild("order");
    $child -> addChild("type", $rec_ord -> get_beer());
    $child -> addChild("quantity", $rec_ord -> get_quantity());
    $child -> addChild("price", $rec_ord -> get_price());
    
    $history->saveXML('data/history.xml');
    }
    catch(Exception $e){
        echo "Error: please reload application";
    }    

    return file_exists('data/history.xml');
}

function order_checkout(){

    $total= 0;
    $price = array();
    $i= 0;
    
    $xmlDoc = new DOMDocument(); 
    
    if (!file_exists('data/history.xml') ){
        
    $file_handle = fopen("data/history.xml", "w") or die("Unable to open file!");
    fclose($file_handle);

    }        
    
    $xmlDoc -> load('data/history.xml');
    
    $items = $xmlDoc -> getElementsByTagName('price');
    $quant = $xmlDoc -> getElementsByTagName('quantity');
    
    foreach ($items as $ii){
        
    array_push($price, $ii -> nodeValue);
    }
    
    foreach ($quant as $q){
                   
    $total+= $price[$i] * ($q -> nodeValue);
    $i++;
    }

    $menu = file_get_contents('data/tap_offers.json');
    $json = json_decode($menu, true);
    
    $json['total']= $total;
    
    $content = json_encode($json);
    file_put_contents('data/tap_offers.json', $content);

return $total;      
}

// -----------------------------------------------------------------------------

function get_name(){

    return $this->name;
}

function get_price(){
    
    return $this->price;
}

function get_quantity(){

    return $this->quantity;
}

}
?>


