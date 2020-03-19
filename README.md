# CoronavirusDataAPI
A PHP API to get cases, recovered and deaths count cause COVID-19 virus. Source: https://www.worldometers.info/coronavirus/

# API Usage
```
require_once "CoronaStatsAPI.php";

$covid = new CoronavirusDataAPI;

echo $covid->getCases("Indonesia"); // get cases

echo $covid->getDeaths("Italy"); // get deaths

echo $covid->getRecovered("Spain"); // get recovered

echo $covid->getTodayCases("Singapore"); // get today/new cases

echo $covid->getTodayDeaths("China"); // get today/new deaths

echo $covid->getAllCases(); // get cases from all country

echo $covid->getAllDeaths(); // get deaths from all country

echo $covid->getAllRecovered(); // get recovered from all country

echo $covid->getAllTodayCases(); // get today/new cases from all country

echo $covid->getAllTodayDeaths(); // get today/new deaths from all country

var_dump($covid->getAll("Malaysia")); // get cases,deaths and recovered as array

var_dump($covid->getCountryCases()); // get all country name infected as array
```
