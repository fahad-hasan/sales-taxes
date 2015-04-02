<?php

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

    public function testCSVLoader() 
    {
        $cart = new Cart();
        DataLoader::loadFromCSV("input1.csv", $cart);
        $this->assertEquals(count($cart->getItems()), 3);
    }

    public function testCartItemBook() {
        $cartItem = CartItemFactory::create(1, "book", 10);
        $this->assertEquals(1, $cartItem->quantity);
        $this->assertEquals("book", $cartItem->name);
        $this->assertEquals(10, $cartItem->base_price);
        $this->assertEquals(0, $cartItem->sales_tax);
        $this->assertEquals(0, $cartItem->import_duty);
        $this->assertEquals(10, $cartItem->price);
    }

    public function testCartItemMusicCD() {
        $cartItem = CartItemFactory::create(1, "music cd", 10);
        $this->assertEquals(1, $cartItem->quantity);
        $this->assertEquals("music cd", $cartItem->name);
        $this->assertEquals(10, $cartItem->base_price);
        $this->assertEquals(1, $cartItem->sales_tax);
        $this->assertEquals(0, $cartItem->import_duty);
        $this->assertEquals(11, $cartItem->price);
    }

    public function testCartItemPerfume() {
        $cartItem = CartItemFactory::create(1, "imported perfume", 10);
        $this->assertEquals(1, $cartItem->quantity);
        $this->assertEquals("imported perfume", $cartItem->name);
        $this->assertEquals(10, $cartItem->base_price);
        $this->assertEquals(1, $cartItem->sales_tax);
        $this->assertEquals(0.5, $cartItem->import_duty);
        $this->assertEquals(11.5, $cartItem->price);
    }

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