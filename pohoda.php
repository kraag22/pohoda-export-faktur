<?php

class Pohoda {

    public static $NS_INVOICE = 'http://www.stormware.cz/schema/version_2/invoice.xsd';
    public static $NS_TYPE = 'http://www.stormware.cz/schema/version_2/type.xsd';

    public $ico = '';

    private $invoices = [];
    private $lastId = 0;

    public function __construct($ico) {
        $this->ico = $ico;
    }

    public function setInvoice($invoice) {
        $this->invoices[] = $invoice;
    }

    public function exportToFile($exportId, $application, $fileName, $errorsNo, $note = '') {

        $xml = $this->export($exportId, $application, $note);
        $incomplete = '';
        if ($errorsNo > 0) {
            $incomplete = '_incomplete';
        }
        $xml->asXML(dirname(__FILE__).'/'.$fileName.'_lastId-'.$this->lastId.$incomplete.'.xml');
    }

    public function exportAsXml($exportId, $application, $note = '') {
        header ("Content-Type:text/xml; charset=utf-8");
        $xml = $this->export($exportId, $application, $note);
        echo $xml->asXML();
    }

    public function exportAsString($exportId, $application, $note = '') {
        $xml = $this->export($exportId, $application, $note);
        echo $xml->asXML();
    }

    private function export($exportId, $application, $note = '') {
        $xmlText = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<dat:dataPack id=\"".$exportId."\" ico=\"".$this->ico."\" application=\"".$application."\" version = \"2.0\" note=\"".$note."\" xmlns:dat=\"http://www.stormware.cz/schema/version_2/data.xsd\"></dat:dataPack>";
        $xml = simplexml_load_string($xmlText);

        $i = 0;
        foreach ($this->invoices as $item) {
            $i++;
            $dataItem = $xml->addChild("dat:dataPackItem");
            $dataItem->addAttribute('version', "2.0");
            $dataItem->addAttribute('id', $exportId . '-' . $i);

            $item->export($dataItem);

            if ($item->varNum > $this->lastId) {
                $this->lastId = $item->varNum;
            }
        }

        return $xml;
    }
}