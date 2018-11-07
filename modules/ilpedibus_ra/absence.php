<?php

$http = eZHTTPTool::instance();
/** @var eZModule $module */
$module = $Params['Module'];
$tpl = eZTemplate::factory();

$status = "(error)/1";

if (
    $http->hasPostVariable('absence_date') &&
    strlen($http->postVariable('absence_date')) &&
    $http->hasPostVariable('absence_line') &&
    $http->hasPostVariable('absence_volunteer')
) {
    $user = eZUser::currentUser();

    $ini = eZINI::instance('ilpedibus.ini');

    $params = array();

    $params['class_identifier'] = "assenza_volontario";
    $params['creator_id'] = $user->ContentObjectID;
    $params['parent_node_id'] = $ini->variable('IlPedibus', 'Assenze');

    $attributesData = array();

    $__DATA = DateTime::createFromFormat("d/m/Y", $http->postVariable('absence_date'));

    $attributesData['data'] = $__DATA->format('U');
    $attributesData['linea'] = $http->postVariable('absence_line');
    $attributesData['volontario'] = $http->postVariable('absence_volunteer');


    $params['attributes'] = $attributesData;

    $object = eZContentFunctions::createAndPublishObject($params);

    if (is_object($object)) {
        $status = "(ok)";
    } else {
        $status = "(error)/2";
    }
}

$module->redirectTo($http->postVariable('__URL__', '/') . "/" . $status);
