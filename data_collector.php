<?php

require_once("interface.php");

$available = 0;
$data_n = array();
$data_p = array();
$data_q = array();
$end= false;
$sum_checkout = 0;
$payers = 1;
$data_ready = false;
$ref = "";

function clean_input($value){

 
    $value = htmlentities($value);
    $value = strip_tags($value);
		
    $bad = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$");
    
    $value = str_ireplace($bad,"",$value);
    $value = stripslashes($value);
    $value = htmlentities($value);
    $value = strip_tags($value);
		
return $value;	
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $data_ready= true;
    $available = clean_input($_POST['aval']);
    $_POST['aval'] = 0;
    
    for (; $available >= 0 ; $available--){
 
        
        $index_n = 'beer' . $available;
        $index_p = 'price' . $available;
        $index_q = 'quant' . $available;

        if ((isset($_POST[$index_n]))){
    
            array_push($data_n, clean_input($_POST[$index_n]));
        }  
    
        if ((isset($_POST[$index_p]))){
    
            array_push($data_p, clean_input($_POST[$index_p]));
        }
    
        if ((isset($_POST[$index_q]))){
    
            array_push($data_q, clean_input($_POST[$index_q]));           
        }

}
}

if ((isset($_GET['end'])) && $_GET['end']== true){
    
    $_GET['end']= false;
    $end = true;
}

if ((isset($_POST['payers']))){
    
    $payers = clean_input($_POST['payers']);
    
    
    $menu = file_get_contents('data/tap_offers.json');
    $json = json_decode($menu, true);
    
    $json['payers']= $payers;
    
    $content = json_encode($json);
    file_put_contents('data/tap_offers.json', $content);
    
    splitter ();
}

if ($data_ready == true){
    
    $i = sizeof($data_n);
    
    for ($i--; $i >= 0 ; $i--){

    $order = new Interfacer($data_n[$i],$data_p[$i],$data_q[$i]);
    $order -> create_order();

    
    $sum_checkout = $order -> order_checkout();
    splitter ();
    }
    
    $data_ready = false;
}   

if ($end== true){
    
    $menu = file_get_contents('data/tap_offers.json');
    $json = json_decode($menu, true);
    
    $json['total']= 0;
    $json['splitted']= 0;    
    $json['payers']= 1;
    
    $content = json_encode($json);
    file_put_contents('data/tap_offers.json', $content);
    
    $end = false;

    $_POST['end']= 'false';
    
    unlink("data/history.xml");
}

function splitter(){
    
    try {
    $menu = file_get_contents('data/tap_offers.json');
    $json = json_decode($menu, true);
    
    if ($json['payers']== 0){
        throw new Exception ("Zero");
    }
    
    $json['splitted']= $json['total']/$json['payers'];
    
    $content = json_encode($json);
    file_put_contents('data/tap_offers.json', $content);
    }
    catch(Exception $e){
        
        if ($e->getMessage == "Zero")
        {echo "Zero divisor";}
        else
        {echo "Error: please reload application";}
    }        
}

header("Location: index.php");
die();
?>

