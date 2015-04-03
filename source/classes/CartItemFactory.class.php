<?php

/*
Class: CartItemFactory
Factory class for creating CartItem objects. 
*/

class CartItemFactory 
{
    use cleanString;

    //Constants
    const SALES_TAX_PERCENT = 0.1;
    const IMPORT_DUTY_PERCENT = 0.05;

    /*
    Checks if an item is imported or not
    Returns true/false
    */
    private function isImported($name) 
    {
        return strpos(strtolower($name), "imported") !== false ? true : false;
    }

    /*
    Checks if an item is exmpted from sales tax or not
    Returns true/false
    */
    private function isTaxExempted($name) 
    {
        $keywords = array("food", "chocolate", "chocolates", "pills", "pill", "book", "books");
        $name_array = explode(" ", strtolower($name));
        if (!empty(array_intersect($name_array, $keywords))) {
            return true;
        } else {
            return false;
        }
    }

    /*
    Calculates sales tax for an item
    Returns number
    */
    private function getSalesTax($name, $price)
    {    
        if (self::isTaxExempted($name)) {
            return 0;
        } else {
            return $price * CartItemFactory::SALES_TAX_PERCENT;
        }
    }

    /*
    Calculates import duty for an item
    Returns number
    */
    private function getImportDuty($name, $price) 
    {
        if (self::isImported($name)) {
            return $price * CartItemFactory::IMPORT_DUTY_PERCENT;
        } else {
            return 0;
        }
    }

    /*
    Creates a new CartItem, calculates atx and import duty
    Returns CartItem object
    */
    public static function create($quantity, $name, $price) 
    {
        $item = array();
        $name = self::cleanString($name);
        $item['quantity'] = $quantity >= 1 ? $quantity : 1;
        $item['name'] = $name;
        $item['price'] = $price;
        $item['sales_tax'] = self::getSalesTax($name, $price);
        $item['import_duty'] = self::getImportDuty($name, $price);

        return new CartItem($item);
    }
}

?>