<div class="popup_create_user popup-visible-none">
    <div class="popup-content">
        
        <button class="button-close popupUser">Закрыть</button>
        <h2> Создание нового пользователя</h2>

        <form id='form_create_user'>
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите логи">
            
            <label>Описание</label>
            <input type="text" name="description" placeholder="Введите описание">

            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль">
        
            <label>Подтверждение пароля</label>
            <input type="password" name="password_confirm" placeholder="Введите подтверждение пароля">
            <label>Роль пользователя</label>
            
            <select class="create_list_role">
                <? foreach($Assoc_array_list_role as $Structure_role) :?>
                    <option value=<?= $Structure_role['id_role'] ?>> <?= $Structure_role['name_role'] ?></option>
                <? endforeach?>
            </select>
            
            <button class="cretateUserPopup styleButtom" type="submit" >Создать</button>
            
            <p id="notification" class="none"></p>
        </form>
    </div>
</div>