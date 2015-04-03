<?php

/*
Include all necessary class files and traits to be able to unit test
*/
include join(DIRECTORY_SEPARATOR, ["source", "classes", "Traits.php"]);
include join(DIRECTORY_SEPARATOR, ["source", "classes", "DataLoader.class.php"]);
include join(DIRECTORY_SEPARATOR, ["source", "classes", "Cart.class.php"]);
include join(DIRECTORY_SEPARATOR, ["source", "classes", "CartItem.class.php"]);
include join(DIRECTORY_SEPARATOR, ["source", "classes", "CartItemFactory.class.php"]);

class testSalesTax extends PHPUnit_Framework_TestCase
{
    /*
    Just a general test if the PHPUnit runs properly
    */
    public function testsSetup() 
    {
        $this->assertTrue(true);
    }

    /*
    Test if the DataLoader class loads CSV files correctly
    */
    public function testCSVLoader() 
    {
        $cart = new Cart();
        DataLoader::loadFromCSV("input1.csv", $cart);

        //This should have 3 items loaded
        $this->assertEquals(count($cart->getItems()), 3);
    }

    /*
    Lets create a item "book" with price 10
    */
    public function testCartItemBook() {
        $cartItem = CartItemFactory::create(1, "book", 10);

        //Check if the item has been created properly
        $this->assertEquals(1, $cartItem->quantity);
        $this->assertEquals("book", $cartItem->name);
        $this->assertEquals(10, $cartItem->base_price);

        //The item should not have any sales tax
        $this->assertEquals(0, $cartItem->sales_tax);

        //The item should not have any import duty
        $this->assertEquals(0, $cartItem->import_duty);

        //The item price should remain the same as base price = 10
        $this->assertEquals(10, $cartItem->price);
    }

    /*
    Lets create a item "music cd" with price 10
    */
    public function testCartItemMusicCD() {
        $cartItem = CartItemFactory::create(1, "music cd", 10);

        //Check if the item has been created properly
        $this->assertEquals(1, $cartItem->quantity);
        $this->assertEquals("music cd", $cartItem->name);
        $this->assertEquals(10, $cartItem->base_price);

        //The item should have 10% sales tax on price
        $this->assertEquals(1, $cartItem->sales_tax);

        //The item shoud NOT have any import duty
        $this->assertEquals(0, $cartItem->import_duty);

        //The price of the item should be base price + salex tax = 11
        $this->assertEquals(11, $cartItem->price);
    }

    /*
    Lets create a item "imported perfume" with price 10
    */
    public function testCartItemPerfume() {
        $cartItem = CartItemFactory::create(1, "imported perfume", 10);

        //Check if the item has been created properly
        $this->assertEquals(1, $cartItem->quantity);
        $this->assertEquals("imported perfume", $cartItem->name);
        $this->assertEquals(10, $cartItem->base_price);

        //The item should have 10% sales tax on price
        $this->assertEquals(1, $cartItem->sales_tax);

        //The item shoud have 5% import duty
        $this->assertEquals(0.5, $cartItem->import_duty);

        //The price of the item should be base price + salex tax + import duty = 11.5
        $this->assertEquals(11.5, $cartItem->price);
    }

    /*
    Check all logic against preset CSV input: input1.csv
    */
    public function testCartInput1() {
        $cart = new Cart();
        $cartItem = CartItemFactory::create(1, "book", 12.49);
        $cart->add($cartItem);
        $cartItem = CartItemFactory::create(1, "music cd", 14.99);
        $cart->add($cartItem);
        $cartItem = CartItemFactory::create(1, "chocolate bar", 0.85);
        $cart->add($cartItem);
        $this->assertEquals(3, count($cart->getItems()));
        $this->assertEquals(1.5, $cart->getSalesTax());
        $this->assertEquals(29.83, $cart->getTotal());
    }

    /*
    Check all logic against preset CSV input: input2.csv
    */
    public function testCartInput2() {
        $cart = new Cart();
        $cartItem = CartItemFactory::create(1, "imported box of chocolates", 10.00);
        $cart->add($cartItem);
        $cartItem = CartItemFactory::create(1, "imported bottle of perfume", 47.50);
        $cart->add($cartItem);
        $this->assertEquals(2, count($cart->getItems()));
        $this->assertEquals(7.65, $cart->getSalesTax());
        $this->assertEquals(65.15, $cart->getTotal());
    }

    /*
    Check all logic against preset CSV input: input3.csv
    */
    public function testCartInput3() {
        $cart = new Cart();
        $cartItem = CartItemFactory::create(1, "imported bottle of perfume", 27.99);
        $cart->add($cartItem);
        $cartItem = CartItemFactory::create(1, "bottle of perfume", 18.99);
        $cart->add($cartItem);
        $cartItem = CartItemFactory::create(1, "packet of headcahe pills", 9.75);
        $cart->add($cartItem);
        $cartItem = CartItemFactory::create(1, "box of imported chocolates", 11.25);
        $cart->add($cartItem);
        $this->assertEquals(4, count($cart->getItems()));
        $this->assertEquals(6.70, $cart->getSalesTax());
        $this->assertEquals(74.68, $cart->getTotal());
    }
    
}

?>