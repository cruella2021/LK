<?php

class Controller{


    function __construct($nameController,$params){
        
        $this->params = $params;
        $this->html = $this->$nameController();
    }
    private function renderTemplate($nameMain,$nameContent = '', $paramTemplate = [], 
                                    $connectScript = [], $hiddenContent = []){
        
        extract($paramTemplate);
        $str_contetnt = '';

        if ( !empty($nameContent) ) {
            ob_start();
            include($nameContent);
            $str_contetnt = ob_get_clean();
        }

        ob_start();
        include($nameMain);
        $main = ob_get_clean();

        $rezult = str_replace ('{{ Content }}', $str_contetnt, $main);

        $rezult = $this->replaceHiddenContent($rezult, $hiddenContent, $paramTemplate);
       
        $rezult = $this->replaceScript($rezult, $connectScript);
        
        return  $rezult;

    }
    private function replaceHiddenContent($page, $hiddenContent, $paramTemplate = []){
        
        if ( is_array($paramTemplate) and count($paramTemplate) > 0 ){
            extract($paramTemplate);
        }

        $strHiddenContent = '';
        
        if ( count($hiddenContent) > 0 ){
            $strHiddenContent = '';

            foreach($hiddenContent as $hiddenString){
                ob_start();
                include($hiddenString);
                $strHiddenContent = $strHiddenContent . ob_get_clean();
            }
            
        }
        
        return str_replace ( '{{ Hidden content }}', $strHiddenContent , $page);

    }

    private function replaceScript($page, $connectScript){
        $linkScript = '';

        if ( count($connectScript) > 0 ){
            $linkScript = '';

            foreach($connectScript as $pathJS){
                $linkScript = $linkScript . '<script src="' . $pathJS .'"></script>';

            }
        }
        return str_replace ( '{{ Connect_script }}', $linkScript , $page);

    }

    private function getDataModels($nameModel,$paramModel = []){
        
        
        $classModel = new $nameModel();
        $arrayData = $classModel->retrunData($paramModel);
        return $arrayData;
        

    }
    private function main(){
        $paramTemplate = ['titlePage' => 'Главная'];
        return $this->renderTemplate('templates/main/main.php','templates/main/content.php', $paramTemplate);
    }
    private function listEmployees(){

            $paramModel = [];
            $paramModel['id_organisation'] = $this->params[1] ?? '';
            $paramModel['id_subnet']       = $this->params[2] ?? '';
            $paramModel['id_employee']     = $this->params[3] ?? '';

            $data = $this->getDataModels('ModelEmployees', $paramModel );
            if ( $paramModel['id_employee'] != ''){
                $tmp = ['paramTemplate' =>  $data, 
                    'id_organisation'=> $paramModel['id_organisation'],
                    'titlePage' => 'Сотрудник'
                ];

                return $this->renderTemplate('templates/main/main.php','templates/employees/employee.php',$tmp); 
            }
            if ($paramModel['id_subnet'] != '' ){
                $tmp = ['paramTemplate' =>  $data, 
                        'id_organisation'=> $paramModel['id_organisation'],
                        'titlePage' => 'Подразделения,сотрудники'
                    ];
                    
                return $this->renderTemplate('templates/main/main.php','templates/employees/staff.php',$tmp);
            }
            
            if ( $paramModel['id_organisation']  != '' ){
                $tmp = ['paramTemplate' =>  $data, 
                                'id_organisation'=> $paramModel['id_organisation'],
                                'titlePage' => 'Подразделения'];
                return $this->renderTemplate('templates/main/main.php','templates/employees/subunit.php',$tmp);
            }

            $tmp = ['paramTemplate' =>  $data, 'titlePage' => 'Организации'];
                        
            return $this->renderTemplate('templates/main/main.php','templates/employees/organization.php',$tmp);
    }
    private function auth(){
        return $this->renderTemplate('templates/auth/auth.php');

    }
    private function users(){
        //Если не админ то на гланую
        if ( empty($_SESSION['Admin']) ) {
            header('Location: ' . BASE_URL);
        }

        $data = $this->getDataModels('ModelUser');
        $role = $this->getDataModels('ModelRoles');
        
        $connectScript = array(BASE_URL . 'js/popup.js');
        $hiddenContent = array('templates/part_page/popup_create_user.php',
                        'templates/part_page/popup_change_user.php');

        $tmp = ['Assoc_array_list_user'=>$data, 
                'Assoc_array_list_role'=>$role,
                'titlePage' => 'Полозьователи'];
        return $this->renderTemplate('templates/main/main.php','templates/users/user.php' , $tmp, $connectScript, $hiddenContent);
        

    }
    private function roles(){

         //Если не админ то на гланую
         if ( empty($_SESSION['Admin']) ) {
            header('Location: ' . BASE_URL);
        }

        $data = $this->getDataModels('ModelRoles');
        $tmp = ['Assoc_array_list_role'=>$data, 
                'titlePage' => 'Роли'];

        $connectScript = array(BASE_URL . 'js/popup.js');
        $hiddenContent = array('templates/part_page/popup_create_role.php',);
        
        return $this->renderTemplate('templates/main/main.php','templates/roles/role.php' , $tmp , $connectScript, $hiddenContent);

    }
    private function exit(){
        session_destroy();
        header('Location: auth');
    
    }

    private function contacts(){
        $tmp = ['titlePage' => 'Контакты',];
        return $this->renderTemplate('templates/main/main.php','templates/contacts/content.php', $tmp);

    }
}