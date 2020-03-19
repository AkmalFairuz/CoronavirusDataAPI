<?php

class CoronavirusDataAPI {

    /** @var array */
    public $data;

    public function __construct()
    {
        $stats = file_get_contents("https://www.worldometers.info/coronavirus/");
        $stats = explode('<table', $stats);
        $stats = explode("</table>", $stats[1]);
        $str = "<html lang='en'><body><table". $stats[0]."</table></body></html>";
        $str = str_replace('style="" role="row" class="even"', "", $str);
        $str = str_replace('style="font-weight: bold; text-align:right"', "", $str);
        $str = str_replace('style="font-weight: bold; text-align:right;background-color:#FFEEAA;"', "", $str);
        $str = str_replace('style="font-weight: bold; text-align:right;background-color:red; color:white"', "", $str);
        $str = str_replace('style="text-align:right;font-weight:bold;"', "", $str);
        $str = str_replace('style="font-weight: bold; text-align:right"', "", $str);
        $str = str_replace('style="font-weight: bold; font-size:15px; text-align:left;"', "", $str);
        $str = str_replace('style="font-weight: bold; text-align:right"', "", $str);
        $str = str_replace('style="color:#00B5F0; font-style:italic; "', "", $str);
        $dom = new DOMDocument;
        $dom->loadHTML($str);
        $x = new DOMXpath($dom);
        $a = 0;
        $array = [];
        $i = 0;
        foreach($x->query('//td') as $td){
            $str = $td->textContent;
            if($str == "Total:") break;
            $array[$i][] = $str;
            $a++;
            if($a === 9) {
                $a = 0;
                $i++;
            }
        }
        $this->data = [];
        foreach($array as $val) {
            if($val[3] == 0) $val[3] = 0;
            if($val[5] == 0) $val[5] = 0;
            $this->data[strtolower($val[0])] = [$val[3], $val[5]];
        }
    }

    public function getCases(string $country) : int {
        return $this->data[strtolower($country)][0];
    }

    public function getDeaths(string $country) : int {
        return $this->data[strtolower($country)][3];
    }

    public function getRecovered(string $country) : int {
        return $this->data[strtolower($country)][5];
    }

    public function getAll(string $country) : array {
        $country = strtolower($country);
        $a = [];
        $a[] = $this->getCases($country);
        $a[] = $this->getDeaths($country);
        $a[] = $this->getRecovered($country);
        return $a;
    }

    public function getCountryCases() : array {
        $a = [];
        foreach($this->data as $key => $val) {
            $a[] = $key;
        }
        return $a;
    }
}

