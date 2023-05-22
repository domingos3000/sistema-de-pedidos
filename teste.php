<?php

$cart_items = array();

$a = 0;

while ($a <= 10) {
    
    $cart_items[] = ['produto' => [
        'nome' => "$a",
        'qtnd' => "$a",
        'valor' => "$a"
    ]];

    $a++;
}

$cart_items_encode = json_encode($cart_items,);

$decodeitems = json_decode($cart_items_encode, true);

echo "<pre>";
 print_r($decodeitems[0]['produto']['nome']);
echo "</pre>";
// $text = 'Frango jjj ddd grelhado (8000 x 2) - Pizza (2500 x 2) - Hamburguer (2000 x 3) -';
// $produto_explode = explode('-' ,$text);
// array_pop($produto_explode);


// // $regex = '/(\(\d+ x \d+\))/i';
// $regex = '/(.*) (\(\d.*\))/i';

// preg_match($regex, $produto_explode[0], $result);



// echo "<pre>";

//     echo $result[1] . "\n" ;
//     $novo = str_replace(')', "", str_replace('(', "", $result[2]));
//     echo $novo;

// echo "</pre>";