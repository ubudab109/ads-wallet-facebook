<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;

class ScrapperDollarController extends Controller
{
    public function index()
    {

        $url = "https://www.bca.co.id/id/informasi/kurs";
        $html = file_get_contents($url);
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();

        if($doc->loadHTML($html)) {
            $result = new DOMDocument();
            $result->formatOutput = true;
            $table = $result->appendChild($result->createElement('table'));
            $thead  = $table->appendChild($result->createElement('thead'));
            $tbody  = $table->appendChild($result->createElement('tbody'));
            $xpath = new DOMXPath($doc);
            $newRow = $thead->appendChild($result->createElement("tr"));
            $row = $xpath->query("//table[@class='m-table-kurs m-table--sticky-first-coloumn m-table-kurs--pad']/tbody/tr[@code='USD']");
            foreach($xpath->query("//table[@class='m-table-kurs m-table--sticky-first-coloumn m-table-kurs--pad']/tbody/tr[@code='USD']") as $row)
            {
                $newRow = $tbody->appendChild($result->createElement('tr'));
                foreach($xpath->query("./td[position()>1 and position()<7]", $row) as $cell)
                {
                    $newRow->appendChild($result->createElement("td", trim($cell->nodeValue)));
                }
            }
            $data = $result->documentElement->textContent;
            $resData = explode(",", $data);
            $dollar = explode('.',$resData[0]);
            $dataDollar = $dollar[0].$dollar[1];

            return response()->json([
                'data' => floatval($dataDollar),
            ], 200);
        }
        
    }
}
