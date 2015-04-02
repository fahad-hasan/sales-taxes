<?php

class Cart 
{
    use sanitizeNumber;

    private $items;
    private $sales_tax;
    private $total;

    public function __construct() 
    {
        $this->items = array();
        $this->sales_tax = 0;
        $this->total = 0;
    }

    public function add(CartItem $item) 
    {
        $this->items[] = $item;
        $this->sales_tax = $this->sales_tax + $item->sales_tax + $item->import_duty;
        $this->total = $this->total + $item->price;
    }

    public function getItems() {
        return $this->items;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getSalesTax() {
        return $this->sales_tax;
    }


    public function checkOut() {
        foreach($this->getItems() as $item) {
            echo implode(", ", array($item->quantity, $item->name, $item->price))."\r\n";
        }
        echo "\r\n";
        echo "Sales Taxes: ".$this->sanitizeNumber($this->getSalesTax())."\r\n";
        echo "Total: ".$this->sanitizeNumber($this->getTotal())."\r\n";
    }
}

?>