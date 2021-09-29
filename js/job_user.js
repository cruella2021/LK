
if (document.getElementById('cretate_user')) {
    cretate_user.onclick = function (event){
        event.preventDefault();
        
        let formData = new FormData(document.forms.form_new_user);
        formData.append("create_user",new Boolean(true));
        
        fetch("system/model/Call_point_js.php",
        {
            method: "POST",
            body: formData
        }).then(res => res.json())
        .then(function(res){
            if (res.error){
                notification.classList.remove('none');
                notification.innerText = res.msg;
                notification.classList.add("error");
            }
        });
    };
}

let button_auth_user = document.getElementById('auth_user');

if (button_auth_user != null){
    button_auth_user.onclick = function (event){
        
        event.preventDefault();
        
        let mainUrl = document.location.pathname.split('/')[1];

        let formData = new FormData(document.forms.auth);
        formData.append("Auth",new Boolean(true));
        console.log(formData);
        
        fetch(`/${mainUrl}/assets/call_point_js.php`,
        {
            method: "POST",
            body: formData
        }).then(res => res.json())
        .then(function(res){

            if (res.error){
                let auth_error = document.getElementById('auth_error')
                auth_error.classList.remove('none');
                auth_error.innerText = res.msg;
                auth_error.classList.add("error");
                
                if ("field" in res){
                    //Если массив полей заполнем то подчеркнем поля красным
                    res.field.forEach(function (field){
                        let input = document.querySelector(`[name="${field}"]`);
                        input.classList.add("error");
                    });
                }
            }else{
                document.location.href ='main';
            }
        });


    };
}

