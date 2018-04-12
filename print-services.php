<?php

$rules = file_get_contents('printRules.json');

header("Content-type:application/json");

echo $rules;

?>