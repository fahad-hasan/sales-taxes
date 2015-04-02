#Salex Tax Calculator

####Usage
Run the following command to see help text and usage.

>php source\sales-tax.php

Welcome to Sales Tax Calculator!
Usage:

--input:        Required        The location of the CSV file

In order to run the unit tests, please run "phpunit --verbose unit-tests.php"

####Example
>php source\sales-tax.php --input="input1.csv"
1,  book, 12.49
1,  music cd, 16.49
1,  chocolate bar, 0.85

Sales Taxes: 1.50
Total: 29.83

####Unit tests
Run the following command.

>phpunit unit-tests.php
PHPUnit 3.7.21 by Sebastian Bergmann.

........

Time: 0 seconds, Memory: 1.75Mb

OK (8 tests, 29 assertions)
