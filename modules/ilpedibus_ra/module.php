<?php

$Module = array( "name" => "IlPedibus Reserved Area" );

$ViewList = array();
$ViewList["absence"] = array(
									"functions" => array( 'absence' ),
									"script" => "absence.php"
							);

$ViewList["substitution"] = array(
									"functions" => array( 'substitution' ),
									"script" => "substitution.php"
							);


$FunctionList = array();
$FunctionList['absence'] = array();
$FunctionList['substitution'] = array();
?>