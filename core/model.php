<?php

class ModelEmployees{


    function __construct()
    {
        
    }

    function retrunData($paramModel = []){
        $connect_1c = '';
        
        if (empty($connect_1c )){
            $connect_1c = new Request_to_1c();
        }
        
        if ( $paramModel['id_employee'] != '' ){
            $Fields = ['Code_organization'=>$paramModel['id_organisation'],
                        'Сode_employee'=>$paramModel['id_employee'] ];
            return $connect_1c->response('GetInfoEmployee',$Fields);
        }

        if ( $paramModel['id_subnet'] != '' ){

            $Fields = ['Code_organization'=>$paramModel['id_organisation'],
                        'Code_subunit'=>$paramModel['id_subnet'] ];
            return $connect_1c->response('GetEmployee',$Fields);
        }

        if ( $paramModel['id_organisation'] != '' ){
            $Fields = ['Code_organization'=>$paramModel['id_organisation'],];
            return $connect_1c->response('GetSubunit',$Fields);
        }

		
        return $connect_1c->response('GetOrg');

    }

}

class ModelUser{

    function retrunData($paramModel = []){

        $users = new ListUsers();
	    return $users->get_list_user();

    }
}


class ModelRoles{

    function retrunData($paramModel = []){

        $roles = new ListRoles();
	    return $roles->get_list_role();

    }
}