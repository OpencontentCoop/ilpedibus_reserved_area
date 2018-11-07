<?php
	$http = eZHTTPTool::instance();
	$module = $Params['Module'];
	$tpl = eZTemplate::factory();

	$__STATUS = "(error)/1";

	if(
		$http->hasPostVariable( 'substitution_absence' ) &&
		$http->hasPostVariable( 'substitution_volunteer' )
	)
	{
        $__USER = eZUser::currentUser();

        $__ILPEDIBUS = eZINI::instance( 'ilpedibus.ini' );

        $params = array();

        $params['class_identifier'] = "sostituzione_volontario";
        $params['creator_id'] = $__USER->ContentObjectID;
        $params['parent_node_id'] = $__ILPEDIBUS->variable( 'IlPedibus','Assenze' );

        $attributesData = array();
        $attributesData['assenza'] = $http->postVariable( 'substitution_absence' );
        $attributesData['volontario'] = $http->postVariable( 'substitution_volunteer' );


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
