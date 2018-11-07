<?php
$http = eZHTTPTool::instance();
/** @var eZModule $module */
$module = $Params['Module'];
$tpl = eZTemplate::factory();

$status = "(error)/1";

if (
    $http->hasPostVariable('substitution_absence') &&
    $http->hasPostVariable('substitution_volunteer')
) {
    $user = eZUser::currentUser();

    $ini = eZINI::instance('ilpedibus.ini');

    $params = array();

    $params['class_identifier'] = "sostituzione_volontario";
    $params['creator_id'] = $user->id();
    $params['parent_node_id'] = $ini->variable('IlPedibus', 'Assenze');

    $attributesData = array();
    $attributesData['assenza'] = $http->postVariable('substitution_absence');
    $attributesData['volontario'] = $http->postVariable('substitution_volunteer');


    $params['attributes'] = $attributesData;

    $object = eZContentFunctions::createAndPublishObject($params);

    if (is_object($object)) {
        $status = "(ok)";
    } else {
        $status = "(error)/2";
    }
}

$module->redirectTo($http->postVariable('__URL__', '/') . "/" . $status);
