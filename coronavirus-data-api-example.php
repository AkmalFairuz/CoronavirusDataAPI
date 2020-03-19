<?php
require_once "CoronaStatsAPI.php";

$covid = new CoronavirusDataAPI;

echo $covid->getCases("Indonesia");

echo $covid->getDeaths("Italy");

echo $covid->getRecovered("Spain");

echo $covid->getTodayCases("Singapore");

echo $covid->getTodayDeaths("China");

echo $covid->getAllCases();

echo $covid->getAllDeaths();

echo $covid->getAllRecovered();

echo $covid->getAllTodayCases();

echo $covid->getAllTodayDeaths();

var_dump($covid->getAll("Malaysia"));

var_dump($covid->getCountryCases());
