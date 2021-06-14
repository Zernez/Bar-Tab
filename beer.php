<?php
class Beer{
    private $name = "";
    private $price = 0;
    private $quantity = 0;
    private $error_message = "";

function __construct($name, $price, $quantity){

    $name_error = $this->set_beer($name) == TRUE ? 'TRUE,' : 'FALSE,';
    $price_error = $this->set_price($price) == TRUE ? 'TRUE,' : 'FALSE,';
    $quantity_error = $this->set_quantity($quantity) == TRUE ? 'TRUE' : 'FALSE';

    $this->error_message = $name_error. $price_error . $quantity_error;
}
//------------------------------------------------------------------------------
public function __toString(){
    
    return $this->error_message;
}

//-----------------------------------------------------------------------------

function set_beer($value){

    $error_message = TRUE;
    (ctype_alpha($value) && strlen($value) > 0) ? $this->name = $value : $this->error_message = FALSE;
    return $this->error_message;
}

function set_price($value){

    $error_message = TRUE;
    ($value > 0) ? $this->price = $value : $this->error_message = FALSE;
    return $this->error_message;
}

function set_quantity($value){

    $error_message = TRUE;
    (strlen($value) > 0) ? $this->quantity = $value : $this->error_message = FALSE;
    return $this->error_message;
}

// -----------------------------------------------------------------------------

function get_beer(){

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


