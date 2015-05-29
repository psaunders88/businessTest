<?php

require 'vendor/autoload.php';

use Business\Business;
use Business\Day;
use Business\Days;

$days = [
    new Day(Days::MONDAY, [['09:00', '17:00']]),
    new Day(Days::TUESDAY, [['09:00', '17:00']]),
    new Day(Days::WEDNESDAY, [['09:00', '17:00']]),
    new Day(Days::THURSDAY, [['09:00', '17:00']]),
    new Day(Days::FRIDAY, [['09:00', '16:00']])
];

$holidays = [];

$timezone = new \DateTimeZone('Europe/London');

$business = new Business($days, $holidays, $timezone);

// Using the closest function
echo "This closest hours to now: \n";
$closest = $business->closest(new \DateTime);
echo $closest->format('d-m-Y H:i')."\n\n";

// Using the timeline function
echo "This is a list of working hours between two dates:\n";
$return = $business->timeline(
    \DateTime::createFromFormat('d-m-Y H:i:s', '01-06-2015 07:00:00'),
    \DateTime::createFromFormat('d-m-Y H:i:s', '01-06-2015 12:00:00'),
    new \DateInterval('PT1H')
);
print_r($return);
echo "\n\n";

// Using the within function on a datetime outside of working hours
echo "Is the time 01-06-2015 08:00:00 during working hours?\n";
$return = $business->within(\DateTime::createFromFormat('d-m-Y H:i:s', '01-06-2015 07:00:00'));
echo ($return ? 'It is within working hours' : 'It is not within working hours') . "\n\n";

// Using the within function on a datetime inside of working hours
echo "Is the time 01-06-2015 11:00:00 during working hours?\n";
$return = $business->within(\DateTime::createFromFormat('d-m-Y H:i:s', '01-06-2015 11:00:00'));
echo ($return ? 'It is within working hours' : 'It is not within working hours') . "\n\n";