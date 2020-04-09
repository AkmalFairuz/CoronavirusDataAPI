<?php

class CoronavirusDataAPI {

    /** @var array */
    public $data;

    public function __construct()
    {
        $x=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
             ),
        );  

        $stats = file_get_contents("https://www.worldometers.info/coronavirus/", false, stream_context_create($x));
        $stats = explode('<table', $stats);
        $stats = explode("</table>", $stats[1]);
        $str = "<html lang='en'><body><table". $stats[0]."</table></body></html>";
        $str = str_replace("style=", "class=", $str); // fix can't be loaded when DOMDocument->loadHTML();
        $str = str_replace(",", "", $str);
        $str = str_replace("+", "", $str);
        $dom = new DOMDocument;
        @$dom->loadHTML($str);
        $x = new DOMXpath($dom);
        $a = 0;
        $array = [];
        $i = 0;
        foreach($x->query('//td') as $td){
            $str = $td->textContent;
            if($str == "Total:") break;
            if($str == "World") continue;
            $array[$i][] = $str;
            $a++;
            if($a === 12) {
                $a = 0;
                $i++;
            }
        }
        $this->data = [];
        foreach($array as $val) {
            if(strlen($val[3]) == 0) $val[3] = 0; // fix 0 is ""
            if(strlen($val[5]) == 0) $val[5] = 0;
            $val[1] = str_replace(" ", "", $val[1]); // fix non numeric integer
            $val[3] = str_replace(" ", "", $val[3]);
            $val[5] = str_replace(" ", "", $val[5]);
            $val[2] = str_replace(" ", "", $val[2]);
            $val[4] = str_replace(" ", "", $val[4]);
            $this->data[strtolower($val[0])] = [$val[1], $val[3], $val[5], $val[2], $val[4]];
        }
    }

    public function getCases(string $country) : int {
        return $this->data[strtolower($country)][0];
    }

    public function getDeaths(string $country) : int {
        return $this->data[strtolower($country)][1];
    }

    public function getRecovered(string $country) : int {
        return $this->data[strtolower($country)][2];
    }

    public function getTodayCases(string $country) : int {
        return $this->data[strtolower($country)][3];
    }

    public function getTodayDeaths(string $country) : int {
        return $this->data[strtolower($country)][4];
    }

    public function getAllCases() : int {
        $cases = 0;
        foreach($this->data as $val) {
            $cases += $val[0];
        }
        return $cases;
    }

    public function getAllTodayCases() : int {
        $todayCases = 0;
        foreach($this->data as $val) {
            $todayCases += $val[3];
        }
        return $todayCases;
    }

    public function getAllTodayDeaths() : int {
        $todayDeaths = 0;
        foreach($this->data as $val) {
            $todayDeaths += $val[4];
        }
        return $todayDeaths;
    }

    public function getAllDeaths() : int {
        $deaths = 0;
        foreach($this->data as $val) {
            $deaths += $val[1];
        }
        return $deaths;
    }

    public function getAllRecovered() : int {
        $recovered = 0;
        foreach($this->data as $val) {
            $recovered += $val[2];
        }
        return $recovered;
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

