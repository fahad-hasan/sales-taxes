<?php

/*
Class: CartItems
Represents a single CartItem object. 
*/

class CartItem
{
    use roundNumber;

    public $name;
    public $quantity;
    public $base_price;
    public $sales_tax;
    public $import_duty;
    public $price;

    /*
    Initializes a new CartItem object from an array
    */
    public function __construct($item) 
    {
        $this->name = $item['name'];
        $this->quantity = $item['quantity'];
        $this->base_price = $item['price'] * $this->quantity;
        $this->sales_tax = $item['sales_tax'] * $this->quantity;
        $this->import_duty = $item['import_duty'] * $this->quantity;
        

        $this->sales_tax = $this->roundNumber($this->sales_tax);
        $this->import_duty = $this->roundNumber($this->import_duty);
        $this->price = $this->base_price + $this->sales_tax + $this->import_duty;
    }

}

?>