<div class="popup_create_role popup-visible-none">
    <div class="popup-content">
        <button class="button-close popupRole">Закрыть</button>
        <h2> Создание новой роли</h2>
        <form id='form_create_role'>
            <label>Имя роли</label>
            <input type="text" name="name" placeholder="Введите имя роли">

            <div >
                <input  type="checkbox" name="is_admin">
                <label>Право администратора? </label>
            </div>

            <button class="cretateRoleServer styleButtom" type="submit" >Создать</button>
            
            <p id="notification" class="none"></p>
        </form>
    </div>
</div>