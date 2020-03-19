# CoronavirusDataAPI
A PHP API to get cases, recovered and deaths count cause COVID-19 virus. Source: https://www.worldometers.info/coronavirus/

# API Usage
```
require_once "CoronavirusDataAPI.php";

$covid = new CoronavirusDataAPI;
echo $covid->getCases("Indonesia"); // get cases

echo $covid->getDeaths("Italy"); // get deaths

echo $covid->getRecorvered("Spain"); // get recovered

var_dump($covid->getCountryCases()); // get all country infected covid-19
```
