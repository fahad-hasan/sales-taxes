<?php

/*
Class: Cart
Represents a single cart object. 
Holds an array of CartItems, accumulated tax and total price of items
*/

class Cart 
{

    private $items;
    private $sales_tax;
    private $total;

    /*
    Initializes a new Cart object
    */
    public function __construct() 
    {
        $this->items = array();
        $this->sales_tax = 0;
        $this->total = 0;
    }

    /*
    Adds a CartItem object to the Cart. Also updates salex tax and total price of items inside the cart.
    */
    public function add(CartItem $item) 
    {
        $this->items[] = $item;
        $this->sales_tax = $this->sales_tax + $item->sales_tax + $item->import_duty;
        $this->total = $this->total + $item->price;
    }

    /*
    Returns an array of CartItems inside the Cart
    */
    public function getItems() 
    {
        return $this->items;
    }

    /*
    Returns total price of items including sales tax
    */
    public function getTotal() 
    {
        return $this->total;
    }

    /*
    Returns the amount of sales tax
    */
    public function getSalesTax() 
    {
        return $this->sales_tax;
    }

    /*
    Checks out all the items and prints output
    Takes Receipt object as input dependency injection
    */
    public function checkOut(Receipt $receipt) 
    {
        $receipt->printReceipt($this);
    }
}

?>