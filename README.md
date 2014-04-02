pohoda-export-faktur
====================

Export invoices to XML format used in accounting software POHODA

Třídy umožní importovat/exportovat faktury do stormware POHODA účetnictnictví. Není to kompletní převod, nezahrnuje to všehny parametry, ale umožňuje to generovat XML, základní validaci a hlásí to chyby. Je to něco co vzniklo jako utilitka SECTION Technologies s.r.o

## Quick Start

```php

require_once('pohoda.php');
require_once('invoice.php');

// zadejte ICO
$pohoda = new Pohoda('01508512');

// cislo faktury
$invoice = new Invoice(324342);

// cena fakutry s DPH
$invoice->setPriceWithoutVAT($price);
$invoice->setPriceOnlyVAT($price*0.21);
$invoice->withVAT(true);

// variabilni cislo
$invoice->setVariableNumber('12345678');
// datum vytvoreni faktury
$invoice->setDateCreated('2014-01-24');
// datum zdanitelneho plneni
$invoice->setDateTax('2014-02-01');
// datum splatnosti
$invoice->setDateDue('2014-02-04');

// text faktury
$invoice->setText('faktura za prace ...');

// nastaveni identity dodavatele
$invoice->setProviderIdentity([
    "company" => "Firma s.r.o.",
    "city" => "Praha",
    "street" => "Nejaka ulice",
    "number" => "80/3",
    "zip" => "160 00",
    "ico" => "034234",
    "dic" => "CZ034234"]);
    
// nastaveni identity prijemce
$invoice->setPurchaserIdentity([
    "company" => "Firma s.r.o.",
    "city" => "Praha",
    "street" => "Nejaka ulice 80/3",
    "zip" => "160 00",
    "ico" => "034234"]);

```

## Validace

```php

if ($invoice->isValid()) {
    $pohoda->setInvoice($invoice);
}
else {
    var_dump($invoice->getErrors());
}

```


## Export

```php

// ulozeni do souboru
$errorsNo = 0; // pokud si pocitate chyby, projevi se to v nazvu souboru
$pohoda->exportToFile(time(), 'popis', date("Y-m-d_H-i-s"), $errorsNo);

// vypsani na obrazovku jako retezec
$pohoda->exportToFile(time(), 'popis', date("Y-m-d_H-i-s"));

// vypsani na obrazovku jako XML s hlavickou
$pohoda->exportAsXml(time(), 'popis', date("Y-m-d_H-i-s")



```
