<div class="popup_change_user popup-visible-none">
    <div class="popup-content">
    <button class="button-close changeUser">Закрыть</button>    
    <h2>Модификация пользователя</h2>
        
        <form id='form_change_user'>
            <label>Логин</label>
            <input type="text" name="login_change" placeholder="Введите логи" autocomplete="off">
            
            <label>Описание</label>
            <input type="text" name="description_change" placeholder="Введите описание" autocomplete="off">

            <label>Пароль</label>
            <input type="password" name="password_change" placeholder="Введите пароль" autocomplete="off">
        
            <label>Подтверждение пароля</label>
            <input type="password" name="password_confirm_change" placeholder="Введите подтверждение пароля" autocomplete="off">

            <input type="hidden" id="id_user" name="id_user">


            <select class="list_role_change">
                <? foreach($Assoc_array_list_role as $Structure_role) :?>
                    <option class="id_role<?= $Structure_role['id_role'] ?>" value=<?= $Structure_role['id_role'] ?>> <?= $Structure_role['name_role'] ?></option>
                <? endforeach?>
            </select>
            
            <label>Код сотрудника</label>
            <input type="text" name="id_1c" placeholder="Введите код сотрудника" autocomplete="off" maxlength="9">

            <button class="sendChangeUser styleButtom" type="submit" >Изменить</button>
            
            <p id="notification_change" class="none"></p>
        </form>
    </div>
</div>