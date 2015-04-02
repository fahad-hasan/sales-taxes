<?php

include join(DIRECTORY_SEPARATOR, ["classes", "Traits.php"]);
include join(DIRECTORY_SEPARATOR, ["classes", "DataLoader.class.php"]);
include join(DIRECTORY_SEPARATOR, ["classes", "Cart.class.php"]);
include join(DIRECTORY_SEPARATOR, ["classes", "CartItem.class.php"]);
include join(DIRECTORY_SEPARATOR, ["classes", "CartItemFactory.class.php"]);

/*
Get command line options
--input: location of the CSV file
*/
$options = getopt("i:", ["input:"]);
if (!empty($options['input'])) {
    try 
    {
        $cart = new Cart();
        DataLoader::loadFromCSV($options['input'], $cart);
        $cart->checkOut();
    } 
    catch(Exception $ex) 
    {
        echo $ex->getMessage();
    }

} else {
    //Print help texts and tests
    print("Welcome to Sales Tax Calculator!\r\n");
    print("Usage:\r\n\r\n");
    print("--input:\tRequired\tThe location of the CSV file\r\n\r\n");
    print("In order to run the unit tests, please run \"phpunit --verbose tests\\tests.php\"\r\n");
}

?>