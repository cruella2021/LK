<?php
    session_start();
   
    include_once('../settings.php');
    include_once('../core/user.php');
    include_once('../core/db.php');

    //АВТОРИЗАЦИЯ ПОЛЬЗОВАТЕЛЯ
    if (array_key_exists('Auth',$_POST) and ($_POST['Auth'])){
        $Login    = $_POST['login'];
        $Password = $_POST['password'];
 
        $Check = new AuthUser($Login,$Password);
        $Answer = $Check->check_user();
        
        echo json_encode($Answer);

        exit();
    }

    //СОЗДАНИЕ ПОЛЬЗОВАТЕЛЯ
    if (array_key_exists('create_user',$_POST) and ($_POST['create_user'])){
        
        $Structure_new_user  = [
            'Login'             => $_POST['login'] ?? '',
            'Description'       => $_POST['description'] ?? '',
            'Password'          => $_POST['password'] ?? '',
            'Password_confirm'  => $_POST['password_confirm'] ?? '',
            'Id_role'           => $_POST['id_role']
        ];

        $user  = new NewUser($Structure_new_user);
        $Answer = $user->run_cretae_user();

        if ($Answer['error']){
            echo json_encode($Answer);
            exit();
        }else{
            echo json_encode($Answer);
            exit();
        }
    }
    
    //ИЗМЕНЕНИЕ ПОЛЬЗОВАТЕЛЯ
    if (array_key_exists('change_user',$_POST) and ($_POST['change_user'])){
        
        $Structure_user  = [
            'Id_user'           => $_POST['id_user'] ?? '',
            'Login'             => $_POST['login_change'] ?? '',
            'Description'       => $_POST['description_change'] ?? '',
            'Password'          => $_POST['password_change'] ?? '',
            'Password_confirm'  => $_POST['password_confirm_change'] ?? '',
            'Id_role'           => $_POST['id_role'],
            'Id_1c'             => $_POST['id_1c']
         ];

        $modification_user = new ChangeUser($Structure_user);
        $Answer = $modification_user->run_change();
        echo json_encode($Answer);
        exit();
    }

    //УДАЛЕНИЕ ПОЛЬЗОВАТЕЛЯ
    if (array_key_exists('remove_user',$_POST) and !empty($_POST['id_user'])){
        $id_user = $_POST['id_user'];

        $remove = new RemoveUser($id_user);
        $Answer = $remove->run_delete();

        exit(json_encode($Answer));

    }

    //СОЗДАНИЕ РОЛИ
    if (array_key_exists('create_role',$_POST) and ($_POST['create_role'])){
        $is_admin = 0;

        if (array_key_exists('is_admin',$_POST) and ($_POST['is_admin'] == 'true')){
            $is_admin = 1;
        }
        
        $Structure_role  = [
            'Name'      => $_POST['name'] ?? '',
            'Is_admin'  => $is_admin,
        ];

        $new_role = new NewRole($Structure_role);
        $Answer = $new_role->run_create_role();
        echo json_encode($Answer);
        exit();
    }

    //УДАЛЕНИЕ РОЛИ
    if (array_key_exists('remove_role',$_POST) and !empty($_POST['id'])){
        $id = $_POST['id'];

        $remove = new RemoveRole($id);
        $Answer = $remove->run_remove();
        echo json_encode($Answer);
        exit();
    }

    //СПИСОК РОЛЕЙ
    if (array_key_exists('get_list_role',$_GET)){

        include_once 'Auth_сreate_user.php';
	    $All_role = new ListRoles();
		$Assoc_array_list_role = $All_role->get_list_role();
        echo json_encode($Assoc_array_list_role);
        exit();

    }

    //ЕСЛИ ДЕЙСТВИЕ НЕ НАЙДЕНО
    $Answer = [
        'error'=>true,
        'msg'=>'Действие не найдено'
    ];    

    echo json_encode($Answer);
    exit();

?>
