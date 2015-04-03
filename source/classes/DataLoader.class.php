<?php

/*
Class: DataLoader
Loads items from a CSV into a cart 
*/

class DataLoader
{
    public static function loadFromCSV($csv_path, Cart &$cart, $headers_first_line = true) 
    {
        if (file_exists($csv_path)) {
            $skip = $headers_first_line;
            $file = fopen($csv_path,"r");
            while(!feof($file)) {
                $items = fgetcsv($file);
                if ($skip) {
                    $skip = false;
                } else if (!$skip) {
                    if (count($items) == 3) {
                        $cartItem = CartItemFactory::create($items[0], $items[1], $items[2]);
                        $cart->add($cartItem);
                    }
                }
            }
            fclose($file);
        } else {
            throw new Exception("Error: The input file\"".$csv_path."\" could not be located.");
        }
    }
}

?>