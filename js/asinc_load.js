
window.addEventListener("load", load_page);

function load_page(){


    loadPhotoEmployee();

    loadCertificateEmploy();
 
}

function loadPhotoEmployee(){

    let pathArray = document.location.pathname.split('/');
    let codeEmployee = pathArray[pathArray.length -1];
    let pathCatalog = pathArray[1];


    let formData = new FormData();
    formData.append("code_employee",codeEmployee);
    formData.append("Type","Photo");
    

    fetch(`/${pathCatalog}/assets/async_load_file.php`,
    {
        method: "POST",
        body: formData
    }).then(res => res.text())
    .then(function(res){
        let photo_employee = document.getElementById('Photo_employee');
        photo_employee.src = "/" + pathCatalog + "/" + res;
    });

}

function loadCertificateEmploy(){

    let pathArray = document.location.pathname.split('/');
    let pathCatalog = pathArray[1];

    let ArrayCertificate = document.querySelectorAll(".Certificate");

    
    ArrayCertificate.forEach( function load_certificate(certificate){
        

        
        let formData = new FormData();
        formData.append("Certificate_code",certificate.id);
        formData.append("Type","Certificate");
        
        fetch(`/${pathCatalog}/assets/async_load_file.php`,
        {
            method: "POST",
            body: formData
        }).then(res => res.text())
        .then(function(res){
            
            let objectCertificate = JSON.parse(res);
            
            if (objectCertificate.url !== '#') {
                /*
                    удалим span на его место поставим ссылку
                */
                let parent = certificate.parentNode;
                let titltCertificate = certificate.innerHTML;
                parent.removeChild(certificate);
                    
                let hrefCertificate =  document.createElement('a');
                hrefCertificate.href = "/" + pathCatalog + "/" + objectCertificate.url;
                hrefCertificate.innerHTML = titltCertificate;
                parent.append(hrefCertificate);
            }
        });

    });
    
}
