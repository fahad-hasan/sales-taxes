<?php

/*
Interface: Receipt
Can be implemented to include different printing methods i.e stdout, file etc
*/

interface Receipt {
	public function printReceipt(Cart $cart);
}

/*
Class: ConsoleReceipt
Represents a receipt object which prints the receipt on stdout
*/

class ConsoleReceipt implements Receipt
{
    use sanitizeNumber;

	public function printReceipt(Cart $cart)
    {
        foreach($cart->getItems() as $item) {
            echo implode(", ", array($item->quantity, $item->name, $item->price))."\r\n";
        }
        echo "\r\n";
        echo "Sales Taxes: ".$this->sanitizeNumber($cart->getSalesTax())."\r\n";
        echo "Total: ".$this->sanitizeNumber($cart->getTotal())."\r\n";
    }
}

?>