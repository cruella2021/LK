<?php

class AuthUser{

    function __construct($Login,$Password){
        $this->Login        = $Login;
        $this->Password     = $Password;
        $this->PasswordHash = md5($Password);
        $this->MySQL        = $GLOBALS['mysqli'];

    } 
    
    private function check_fileds():array{
       
        $fields_error = [];

        $Answer = ['error'=>false,];

        if (empty($this->Login)){
            $fields_error[] = 'login';
        }

        if (empty($this->Password)){
            $fields_error[] = 'password';
        }

        if (!empty($fields_error)){

            $Answer = [
                    'error'=>true,
                    'msg'=>'Заполните поля',
                    'field'=>$fields_error
            ];
        }
        

        return $Answer;
    }

    public function check_user(){
        
        $Answer = $this->check_fileds();
   
        //Если есть не заполненые поля тогда вернем сообщение
        if ($Answer['error']){
            return $Answer;
            die();
        }

        $Query = "SELECT user.name as name_user, user.id_1C as id_1c, role.is_admin as is_admin , role.name as name_role  FROM `Users` AS `user`
                    LEFT JOIN RoleUsers as role  On user.role = role.id
                    WHERE user.name = :Login and user.password = :PasswordHash";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Login'        => $this->Login,
            'PasswordHash' => $this->PasswordHash
        ];
    
        $Worker->execute($Parms_Worker);

        $Rezult_query = $Worker->fetchAll();
        if ( count($Rezult_query) === 1) 
        {
            $_SESSION['User']  = $this->Login;
            $_SESSION['id_1c'] = $this->Login;
            
            if ( (int)$Rezult_query[0]['is_admin'] === 1){
                $_SESSION['Admin']=True;
            }

            $_SESSION['id_1c']= $Rezult_query[0]['id_1c'];
            
            $Answer = [
                    'error'=>false,
                    'msg'=>'Успешно'
                ];
            
        }else{
            $Answer = [ 
                'error'=>true,
                'msg'=>'Не правильный логин или пароль'
            ];
		}
       
        //Отправим результат обратно клиенту    
        return $Answer;
    }
    
}

class NewUser{

    function __construct($Structure_new_user){

        $this->Login            = htmlspecialchars(trim($Structure_new_user['Login']));
        $this->Password         = $Structure_new_user['Password'];
        $this->PasswordHash     = md5($Structure_new_user['Password']);
        $this->Password_confirm = $Structure_new_user['Password_confirm'];
        $this->Description      = htmlspecialchars(trim($Structure_new_user['Description']));
        $this->Id_role          = $Structure_new_user['Id_role'];
        $this->uniqid           = uniqid();
        $this->MySQL            = $GLOBALS['mysqli'];

    }

    private function field_validation(){
        $Answer = [
            'error'=>false,
            ];
            
        if (strlen($this->Login) == 0){
            $Answer = [
                'error'=>true,
                'msg'=>'Логин не может быть пустым'
                ];
            return $Answer;
        }

        if (strlen($this->Id_role) == 0){
            $Answer = [
                'error'=>true,
                'msg'=>'Роль не может быть пустым'
                ];
            return $Answer;
        }
    
        if (strlen($this->Password) == 0 or strlen($this->Password_confirm) ==0 ){
            $Answer = [
                'error'=>true,
                'msg'=>'Пароли и подтверждение пароля должны быть заполнены'
                ];
            return $Answer;
        }

        if ($this->Password != $this->Password_confirm){
            $Answer = [
                'error'=>true,
                'msg'=>'Пароли не совпадают'
                ];
            return $Answer;
        }

        return  $Answer;
    }

    private function login_is_exist(){

        $Query = "SELECT name FROM Users WHERE name = :Login";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Login' => $this->Login,
        ];
    
        $Worker->execute($Parms_Worker);
        
        if ( $Worker->rowCount()  > 0 ) {

            $Answer = [
                'error'=>true,
                'msg'=>'Имя пользователя занято'
                ];
            return $Answer;
        }

        $Answer = [
            'error'=>false,
            ];
        return $Answer;
    }

    private function id_is_exist(){

        $Query = "SELECT id FROM RoleUsers WHERE id = :Id_role ";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Id_role'        => $this->Id_role
        ];
    
        $Worker->execute($Parms_Worker);
        
        if ($Worker->rowCount()  != 1 ) {

            $Answer = [
                'error'=>true,
                'msg'=>'Роль не существует занято'
                ];
            return $Answer;
        }

        $Answer = [
            'error'=>false,
            ];
        return $Answer;
    }

    private function create_user(){
        
        $Query = "INSERT INTO Users (id, name, description, password, role, uniqid) VALUES (NULL, :Login, :Description, :PasswordHash, :Id_role, :uniqid)";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Login'        => $this->Login,
            'Description'  => $this->Description,
            'PasswordHash' => $this->PasswordHash,
            'Id_role'      => $this->Id_role,
            'uniqid'       => $this->uniqid
        ];
    
        $Worker->execute($Parms_Worker);

        

        if ( $Worker->errorInfo()[0] !== PDO::ERR_NONE ){
            //error_log($this->MySQL->error);

            $Answer = [
                'error'=>true,
                'msg'=>'Пользователь не создан'
                ];
            return $Answer;

        }else{
            $Answer = [
                'error'=>false,
                'msg'=>'Пользователь создан'
                ];
            return $Answer;
        }
    }

    public function run_cretae_user(){

        $List_error = $this->field_validation();
        if ($List_error['error']){
            return $List_error;
        }

        $List_error = $this->login_is_exist();
        if ($List_error['error']){
            return $List_error;
        }

        $List_error = $this->id_is_exist();
        if ($List_error['error']){
            return $List_error;
        }
        return $this->Create_user();

    }
}

class RemoveUser {

    function __construct($id_user){

        $this->Id_user   = $id_user;
        $this->MySQL     = $GLOBALS['mysqli'];

    }

    private function id_is_exist() {

        $Query = "SELECT id FROM Users WHERE id = :Id_user ";
        $Worker = $this->MySQL->prepare($Query);
        
        $Parms_Worker = [
            'Id_user'        => $this->Id_user,
        ];
    
        $Worker->execute($Parms_Worker);

        if ( $Worker->rowCount()  != 1 ) {

            $Answer = [
                'error'=>true,
                'msg'=>'Не возможно удалить пользователя'
                ];
            return $Answer;
        }

        $Answer = [
            'error'=>false,
            ];
        return $Answer;
    }

    private function delete_forever() {
        $Query = "DELETE FROM Users WHERE id = :Id_user";
        $Worker = $this->MySQL->prepare($Query);
        
        $Parms_Worker = [
            'Id_user'        => $this->Id_user,
        ];
    
        $Worker->execute($Parms_Worker);

        if ( $Worker->errorInfo()[0] !== PDO::ERR_NONE){
            $Answer = [
                'error'  => true,
                'msg'    => 'Ошибка удаления пользователя'    
            ];
            return $Answer;
        }

        $Answer = [
            'error'  => false,
        ];
        return $Answer;

    }

    public function run_delete() {

        $Answer = $this->id_is_exist();
        if ($Answer['error']){
            return $Answer;
        }

        return $this->delete_forever();


    }

}

class ListUsers{

    function __construct(){
        $this->MySQL   = $GLOBALS['mysqli'];
    }

    public function get_list_user(){
        $List_user = array();

        $Query = "SELECT user.id as id_user, user.name as name_user, user.description as description_user, user.id_1C as id_1C,
                        role.id as id_role, role.name as name_role FROM Users as user
                        LEFT JOIN RoleUsers as role ON user.role = role.id";
        $Worker = $this->MySQL->prepare($Query);
        $Worker->execute();
        $Array_list_user = $Worker->fetchAll(PDO::FETCH_ASSOC);

        foreach($Array_list_user as $Row=>$Structure_user){
            $List_user[] = $Structure_user;
        }

        return $List_user;
    }

}

class ChangeUser{

    function __construct($Structure_user){

        $this->Id_user          = $Structure_user['Id_user'];
        $this->Login            = htmlspecialchars(trim($Structure_user['Login']));
        $this->Password         = $Structure_user['Password'];
        $this->PasswordHash     = md5($Structure_user['Password']);
        $this->Password_confirm = $Structure_user['Password_confirm'];
        $this->Description      = htmlspecialchars(trim($Structure_user['Description']));
        $this->Id_role          = $Structure_user['Id_role'];
        $this->Id_1c            = $Structure_user['Id_1c'];
        $this->MySQL            = $GLOBALS['mysqli'];
    }
    
    private function id_is_exist(){
        $Query = "SELECT name FROM Users WHERE id = :Id_user ";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Id_user' => $this->Id_user,
        ];
    
        $Worker->execute($Parms_Worker);
        
        if ( $Worker->rowCount()  == 0 ) {
            $Answer = [
                'error'=>true,
                'msg'=>'Пользователь не найден'
                ];
            return $Answer;
        }

        $Answer = [
            'error'=>false,
            ];
        return $Answer;
    }

    private function check_fileds():array{
       
        $fields_error = [];

        $Answer = ['error'=>false,];

        if (empty($this->Login)){
            $fields_error[] = 'login';
        }

        if (empty($this->Password)){
            $fields_error[] = 'password';
        }

        if (empty($this->Password_confirm)){
            $fields_error[] = 'password_confirm';
        }

        if (!empty($fields_error)){

            $Answer = [
                    'error'=>true,
                    'msg'=>'Заполните поля',
                    'field'=>$fields_error
            ];
        }
        

        return $Answer;
    }

    private function field_validation(){
        $Answer = [
            'error'=>false,
            ];
            
        if (strlen($this->Login) == 0){
            $Answer = [
                'error'=>true,
                'msg'=>'Логин не может быть пустым'
                ];
            return $Answer;
        }
    
        if (strlen($this->Password) == 0 or strlen($this->Password_confirm) ==0 ){
            $Answer = [
                'error'=>true,
                'msg'=>'Пароли и подтверждение пароля должны быть заполнены'
                ];
            return $Answer;
        }

        if ($this->Password != $this->Password_confirm){
            $Answer = [
                'error'=>true,
                'msg'=>'Пароли не совпадают'
                ];
            return $Answer;
        }

        return  $Answer;
    }

    private function modification(){
        
        $Query = "UPDATE Users SET name = :Login, description = :Description, password = :PasswordHash , role = :Id_role, id_1C = :Id_1c WHERE Users.id = :Id_user";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Login'        => $this->Login,
            'Description'  => $this->Description,
            'PasswordHash' => $this->PasswordHash,
            'Id_role'      => $this->Id_role,
            'Id_user'      => $this->Id_user,
            'Id_1c'        => $this->Id_1c

            
        ];
    
        $Worker->execute($Parms_Worker);

        if ( $Worker->errorInfo()[0] !== PDO::ERR_NONE ){
            error_log($Worker->errorInfo()[2]);

            $Answer = [
                'error'=>true,
                'msg'=>'Данные пользователя не обновлены'
                ];
            return $Answer;

        }else{
            $Answer = [
                'error'=>false,
                'msg'=>'Данные обновлены'
                ];
            return $Answer;
        }

    }

    public function run_change(){

        $Answer = $this->check_fileds();
        if ($Answer['error']){
            return $Answer;
        }
        
        $Answer =$this->field_validation();
        if ($Answer['error']){
            return $Answer;
        }

        $Answer = $this->id_is_exist();
        if ($Answer['error']){
            return $Answer;
        }

        $Answer =$this->modification();
        return $Answer;


    }

}

class ListRoles{

    function __construct(){
        $this->MySQL = $GLOBALS['mysqli'];
    }

    public function get_list_role(){
        $List_role = array();

        $Query = "SELECT role.id as id_role, role.name as name_role, role.is_admin as is_admin
                        FROM RoleUsers as role ";
        $Worker = $this->MySQL->prepare($Query);
        $Worker->execute();
        $Array_role = $Worker->fetchAll(PDO::FETCH_ASSOC);

        foreach($Array_role as $Row=>$Structure_role){
            $List_role[] = $Structure_role;
        }

        return $List_role;
    }

}

class NewRole{

    function __construct($Structure_new_user){

        $this->Name            = htmlspecialchars(trim($Structure_new_user['Name']));
        $this->Is_admin        = $Structure_new_user['Is_admin'];
        $this->MySQL           = $GLOBALS['mysqli'];

    }

    private function field_validation(){
        $Answer = [
            'error'=>false,
            ];
        
        if (strlen($this->Name) == 0){
            $Answer = [
                'error' =>true,
                'msg'   =>'Имя не может быть пустым',
                'field' => array('name')
            ];
            return $Answer;
        }

        return  $Answer;
    }

    private function role_is_exist(){

        $Query = "SELECT is_admin FROM RoleUsers WHERE name = :Name";
        $Rezult_query = $this->MySQL->query($Query);
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Name'        => $this->Name,
            ];
    
        $Worker->execute($Parms_Worker);

        if ( $Worker->rowCount() > 0 ) {

            $Answer = [
                'error'=>true,
                'msg'=>'Роль с таким именем существует'
                ];
            return $Answer;
        }

        $Answer = [
            'error'=>false,
            ];
        return $Answer;
    }

    private function create_role(){
        
        $Query = "INSERT INTO RoleUsers (id, name,  is_admin) VALUES (NULL, :Name, :Is_admin)";
        $Rezult_query = $this->MySQL->query($Query);
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Name'        => $this->Name,
            'Is_admin'    => $this->Is_admin,
            ];
    
        $Worker->execute($Parms_Worker);

        if ( $Worker->errorInfo()[0] !== PDO::ERR_NONE ){
            //error_log($this->MySQL->error);

            $Answer = [
                'error'=>true,
                'msg'=>'Роль не создана'
                ];
            return $Answer;

        }else{
            $Answer = [
                'error'=>false,
                'msg'=>'Роль создан'
                ];
            return $Answer;
        }

    }

    public function run_create_role(){

        $List_error = $this->field_validation();
        if ($List_error['error']){
            return $List_error;
        }

        $List_error = $this->role_is_exist();
        if ($List_error['error']){
            return $List_error;
        }

        return $this->create_role();

    }


}

class RemoveRole{

    function __construct($id){
        $this->MySQL = $GLOBALS['mysqli'];
        $this->Id    = $id;
    }

    private function id_role_exist(){
        
        $Query = "SELECT name FROM RoleUsers WHERE id = :Id";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Id'        => $this->Id,
        ];
    
        $Worker->execute($Parms_Worker);
        
        if ( $Worker->rowCount() > 0 ) {

            $Answer = [
                'error'=>false,
                ];
            return $Answer;
        }

        $Answer = [
            'error'=>false,
            'msg'=>'Роль не существует'
            ];
        return $Answer;

    }

    private function delete_role_forever(){
        $Query = "DELETE FROM RoleUsers WHERE id = :Id";
        $Worker = $this->MySQL->prepare($Query);

        $Parms_Worker = [
            'Id'        => $this->Id,
        ];
    
        $Worker->execute($Parms_Worker);
        
        if ( $Worker->errorInfo()[0] !== PDO::ERR_NONE ){
            //error_log($this->MySQL->error);
            $Answer = [
                'error'  => true,
                'msg'    => 'Ошибка удаления роли'    
            ];
            return $Answer;
        }

        $Answer = [
            'error'  => false,
        ];
        return $Answer;
    }


    public function run_remove(){

        $Answer = $this->id_role_exist();
        if($Answer['error']){
            return $Answer;
        }

        return $this->delete_role_forever();

    }

}