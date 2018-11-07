<?php

	$http = eZHTTPTool::instance();
	$module = $Params['Module'];
	$tpl = eZTemplate::factory();

	$__STATUS = "(error)/1";

	if(
		$http->hasPostVariable( 'absence_date' ) &&
		strlen($http->postVariable( 'absence_date' )) &&
		$http->hasPostVariable( 'absence_line' ) &&
		$http->hasPostVariable( 'absence_volunteer' )
	)
	{
        $__USER = eZUser::currentUser();

        $__ILPEDIBUS = eZINI::instance( 'ilpedibus.ini' );

        $params = array();

        $params['class_identifier'] = "assenza_volontario";
        $params['creator_id'] = $__USER->ContentObjectID;
        $params['parent_node_id'] = $__ILPEDIBUS->variable( 'IlPedibus','Assenze' );

        $attributesData = array();

        $__DATA = DateTime::createFromFormat("d/m/Y", $http->postVariable( 'absence_date' ));

//         print_r($__DATA);
//         die("--------<br>");
        $attributesData['data'] = $__DATA->format('U');
        $attributesData['linea'] = $http->postVariable( 'absence_line' );
        $attributesData['volontario'] = $http->postVariable( 'absence_volunteer' );


        $params['attributes'] = $attributesData;

        $__OBJ = eZContentFunctions::createAndPublishObject($params);

        if(is_object($__OBJ))
        {
            $__STATUS = "(ok)";
        }
        else
        {
            $__STATUS = "(error)/2";
        }
	}

	$module->redirectTo($http->postVariable( '__URL__' )."/".$__STATUS );
?>
