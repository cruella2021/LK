
//ЗАКРЫТИЕ POPUP CREAT-USER,MODIFY-USER,CHANGE-USER
let popupCloseAll = document.querySelectorAll('.button-close');
if ( popupCloseAll != null ){
    popupCloseAll.forEach(function(elem){
        elem.addEventListener('click', function(e){
        
            if (e.target.classList.contains('popupUser')){
                let popup = document.querySelector('.popup_create_user');
                popup.classList.toggle('popup-visible-none');
            }
            
            if (e.target.classList.contains('changeUser')){
                let popup = document.querySelector('.popup_change_user');
                popup.classList.toggle('popup-visible-none');
            }
    
            if (e.target.classList.contains('popupRole')){
                let popup = document.querySelector('.popup_create_role');
                popup.classList.add('popup-visible-none');
            }
            
        });
    
    });
}


//Popup Создание пользователя
let buttonCreateUser = document.querySelector('.createUser');
if ( buttonCreateUser != null ){
    buttonCreateUser.addEventListener('click',function(){
        let popup = document.querySelector('.popup_create_user');
        popup.classList.toggle('popup-visible-none');
    });
}

//Popup Создание роли
let buttonCreateRole = document.querySelector('.createRole');
if ( buttonCreateRole != null ){
    buttonCreateRole.addEventListener('click',function(){
        let popup = document.querySelector('.popup_create_role');
        popup.classList.toggle('popup-visible-none');
    });
}


//МОДИФИКАЦИЯ ПОЛЬЗОВАТЕЛЯ
let buttonCanhgeUser = document.querySelector('.sendChangeUser');
if ( buttonCanhgeUser != null ){
    buttonCanhgeUser.addEventListener('click',changeUserServer);
}


let buttom_create_user = document.querySelector('.cretateUserPopup');
if (buttom_create_user !=null){
        buttom_create_user.onclick = function(event){
        event.preventDefault();
        let mainUrl = document.location.pathname.split('/')[1];
        
        let id_role = document.querySelector('.create_list_role').selectedOptions[0].value;

        let formData = new FormData(document.forms.form_create_user);
        formData.append('create_user',true);
        formData.append('id_role',id_role);

        fetch(`/${mainUrl}/assets/call_point_js.php`,
        {
            method: "POST",
            body: formData
        }).then(res => res.json())
        .then(function(res){
            if (!res.error){

                //Если посльзователь создан очистим все поля
                document.querySelectorAll('input').forEach(function (elem){
                    elem.value = '';
                    
                    let notification = document.getElementById('notification')
                    notification.innerHTML = 'Пользователь создан';
                    notification.classList.remove('none');
                });
            }else{
                let notification = document.getElementById('notification')
                notification.innerHTML = res.msg;
                notification.classList.remove('none');
            }
        });
    }
}

//УСТНОВКА ДЕЙСТВИЙ ДЛЯ КНОПОК В ТАБЛИЧНОЙ ЧАСТИ
let tabelUser = document.querySelector(".table-users");
if (tabelUser !== null){
    tabelUser.addEventListener('click', clickButtonTables);
}

function clickButtonTables(e){
    let element = e.target;
    
    if (element.classList.contains('delUser') || element.classList.contains('changeUser')){
        if (element.classList.contains('changeUser')){
            openFormChangeUser(element);
        }
        
        if (element.classList.contains('delUser')){
            removeUser(element);
        }
    }
    
}

//ОТКРЫТЬ ФОРМУ ИЗМЕНЕНИЯ ПОЛЬЗОВАТЕЛЯ
function openFormChangeUser(elem) {

        user_id     = elem.dataset.id_user;
        name_login  = elem.dataset.name_login;
        description = elem.dataset.descriptio;
        id_role     = elem.dataset.id_role;
        id_1c       = elem.dataset.id_1c;
        
        //Установить значение в поля 
        let formChange = document.querySelector('[id="form_change_user"]');
        
        let id_user = formChange.querySelector('[name="id_user"]');
        id_user.value = user_id;

        let login_change = formChange.querySelector('[name="login_change"]');
        login_change.value = name_login;

        let description_change = formChange.querySelector('[name="description_change"]');
        description_change.value = description;

        let optionRole = formChange.querySelector(`.id_role${id_role}`);
        optionRole.setAttribute('selected', 'selected');
   
        let user_id_1c = formChange.querySelector('[name="id_1c"]');
        user_id_1c.value = id_1c;

        let div_change = document.querySelector('.popup_change_user');
        div_change.classList.toggle('popup-visible-none');
        
}

//ИЗМЕНИТЬ ПОЛЬЗОВАТЕЛЯ НА СЕРВЕРЕ
function changeUserServer(e){
    e.preventDefault();
    
    let mainUrl = document.location.pathname.split('/')[1];

    let id_role = document.querySelector('.list_role_change').selectedOptions[0].value;
    
    let formData = new FormData(document.forms.form_change_user);
    formData.append("change_user",new Boolean(true));
    formData.append("id_role",id_role);
    

      
    fetch(`/${mainUrl}/assets/call_point_js.php`,{
        method: "POST",
        body: formData
    }).then(res => res.json())
    .then(function(res){
        console.log(res)
        if ( !res.error ){

            let popup_change_user = document.querySelector('[class="popup_change_user"]');
            popup_change_user.classList.toggle('popup-visible-none');
            location.reload();
            //убрать сохранение пароля     
        }else{

            let notification = document.getElementById('notification_change')
            notification.innerHTML = res.msg;
            notification.classList.remove('none');
            
            if ("field" in res){
                
                res.field.forEach( function (field){

                let input = document.querySelector(`[name="${field}_change"]`);
                input.classList.add("error");
            });
        }
        }
    });
}

//УДАЛИТЬ ПОЛЬЗОВАТЕЛЯ НА СЕРВЕРЕ
function removeUser(elem) {

    let mainUrl = document.location.pathname.split('/')[1];

    let formData = new FormData();
    formData.append('remove_user', true);
    formData.append('id_user', elem.dataset.id_user);
    
    
    fetch(`/${mainUrl}/assets/call_point_js.php`,{
        method: "POST",
        body: formData
    }).then(res => res.json())
    .then(function(res){

        if ( !res.error ){
            
            //!!!!!!!!!!!!!!!!
            //ОБНОВИТЬ СПИСОК ПОЛЬЗОВАТЕЛЕЙ
            //!!!!!!!!!!!!!!!!
            
        }else{
            console.log(res.msg);

        }
    });
    
}


//ОТКРЫТЬ ФОРМУ СОЗДАНИЕ РОЛИ
let button_create_role = document.querySelector('.openPopupNewRole');
if (button_create_role != null){
    button_create_role.addEventListener('click', openFormNewRole);
}

function openFormNewRole(e){
    e.preventDefault();
    let popup_role = document.querySelector('.popup_create_role');
    if (popup_role != null){
        popup_role.classList.remove('popup-visible-none');
    }
}


//СОЗДАНИЕ РОЛИ НА СЕРВЕРЕ
let buttomCretateRole = document.querySelector('.cretateRoleServer');
if (buttomCretateRole != null){
    buttomCretateRole.addEventListener('click', cretareNewRoleServer);
}

function cretareNewRoleServer(e){
    e.preventDefault();
    let mainUrl = document.location.pathname.split('/')[1];

    let form_role = new FormData(document.forms.form_create_role);
    form_role.append("create_role",new Boolean(true));
    
    if (!form_role.get('is_admin')){
        form_role.append("is_admin",new Boolean(false));
    }else{
        form_role.append("is_admin",new Boolean(true));
    }

    fetch(`/${mainUrl}/assets/call_point_js.php`,{
        method: "POST",
        body: form_role
    }).then(res => res.json())
    .then(function(res){
        
        if (!res.error){
            document.querySelectorAll('input').forEach(function (elem){
                elem.value = '';
                
                location.reload();
                /*
                let notification = document.getElementById('notification')
                notification.innerHTML = 'Роль создана';
                notification.classList.remove('none');
                */
            });
        }else{
            if ("field" in res){
                 res.field.forEach( function (field){

                let input = document.querySelector(`[name="${field}"]`);
                input.classList.add("error");
            });
            }
        }

    });
}


//УСТНОВКА ДЕЙСТВИЙ ДЛЯ КНОПОК В ТАБЛИЧНОЙ ЧАСТИ
let tabelRole = document.querySelector(".table-role");
if (tabelRole !== null){
    tabelRole.addEventListener('click', clickButtonTablesRole);
}

function clickButtonTablesRole(e){

    let target = e.target;
    if (target.classList.contains('delRole')){
        let id_role = target.dataset.id_role;
        
        removeRoleServer(id_role);
    }
    
}

function removeRoleServer(id){

    let mainUrl = document.location.pathname.split('/')[1];
    
    let formData = new FormData();
    formData.append('remove_role',true);
    formData.append('id',id);
    
    fetch(`/${mainUrl}/assets/call_point_js.php`,{
        method: "POST",
        body: formData
    }).then(res => res.json())
    .then(function(res){
        if (!res.error){
            location.reload();
        }
    });
}


//Будем закрывать окно popup по Escape
/*
let formChange = document.querySelector(".popup_change_user");
formChange.addEventListener('keydown', function(event) {
    console.log(123);
    if ( event.code == 'Escape') {
        
        let form_change_user = document.querySelector('.popup_change_user');
        if ( form_change_user != null ) {
            form_change_user.classList.add('popup-visible-none');
        }
        
        
        let form_create_user = document.querySelector('.popup_create_user');
        if ( form_create_user != null ) {
            form_create_user.classList.add('popup-visible-none');
        }
        
    }
  });
*/