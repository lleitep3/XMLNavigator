<?php

include 'xmlNavigator.php';

$xml = 'demo.xml';
$nav = new XMLNavigator($xml);
header('Content-type: text/xml');
echo '<root>';
echo $nav->class;
echo $nav->studant(array('age' => '11'));
echo $nav->teacher(array('id' => '2'));
// here we have an array by XMLNavigator
$array = $nav->all('teacher');
foreach ($array as $n)
    echo $n;

// here we have an array by XMLNavigator
$array = $nav->all('studant', array('age' => '18'));
foreach ($array as $n)
    echo $n;

echo $nav->teacher(array('id' => '2'))->studant(array('age' => '19'));
echo '</root>';