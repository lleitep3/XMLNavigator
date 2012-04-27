XMLNavigator
===========


Simple navigation in a xml file or xml string


**Example:**

    <?php
    include 'XMLNavigator.php';

    $xml = <<< XML
    <? xml version="1.0" encoding="UTF-8"?>
    <school>
        <class number="12">
            <teacher name="teacher 1" id="1"/>
            <studants>
                <studant name="studant 1" age="9"/>
                <studant name="studant 2" age="10"/>
                <studant name="studant 3" age="18"/>
                <studant name="studant 4" age="11"/>
                <studant name="studant 5" age="11"/>
            </studants>
        </class>    
        <class number="20">
            <teacher name="teacher 2" id="2"/>
            <studants>
                <studant name="studant 10" age="22"/>
                <studant name="studant 20" age="23"/>
                <studant name="studant 30" age="18"/>
                <studant name="studant 40" age="18"/>
                <studant name="studant 50" age="19"/>
            </studants>
        </class>
    </school>
    XML;

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