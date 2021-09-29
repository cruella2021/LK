<?
    include_once '../settings.php';
    include_once '../core/query1c.php';

    if (!isset($_POST['Type'])){
        echo "Not set Type";
        exit();
    }

    $Type = $_POST['Type'];
    
    if ($Type == "Photo"){
        $Сode_employee = $_POST['code_employee'];   
        load_photo_employee($Сode_employee);

    }elseif($Type == "Certificate"){
        $Certificate_code = $_POST['Certificate_code'];
        load_certificate_employee($Certificate_code);
    }

    function load_photo_employee($Сode_employee){
       
        if (empty($Сode_employee)){
            echo '../images/employee/default';
            exit();
        }
        
        $Fields = ['Сode_employee'=>$Сode_employee,'Type_file'=>'Photo'];

        $Connect_1c = new Request_to_1c();
        $Structure_name_file_photo_employee = $Connect_1c->response('GetNameImageEmployee',$Fields);
        
        if (!empty($Structure_name_file_photo_employee) and $Structure_name_file_photo_employee->Exist){
            
            if (file_exists('../images/employee/' . $Structure_name_file_photo_employee->Name)){
                echo 'images/employee/' . $Structure_name_file_photo_employee->Name;
                exit();
            }else{
                $Save_path = '../images/employee/' . $Structure_name_file_photo_employee->Name;

                $Fields = ['Сode_employee'=>$Сode_employee];

                $Path_to_photo_employee = $Connect_1c->get_file('GetImageEmployee',$Fields,$Save_path,'');
            
                include_once 'convert_image.php';
            
                convert($Save_path);

                echo 'images/employee/' . $Structure_name_file_photo_employee->Name;
                exit();
            }
        }else{
            
            echo 'images/employee/default';
            exit();
        }
        
        unset($Connect_1c);


    }


    function load_certificate_employee($Certificate_code){

        if (empty($Certificate_code)){
            $array_url_code = ['Certificate_code'=>$Certificate_code,'url'=>'#'];
            echo json_encode($array_url_code);
            exit();
        }

        if (file_exists('../certificate/' . $Certificate_code)){
            $array_url_code =['Certificate_code'=>$Certificate_code,'url'=>'certificate/' . $Certificate_code];

            echo json_encode($array_url_code);
            exit();
        }

       

        $Fields = [
            'Certificate_code'=>$Certificate_code,'Type_file'=>'Certificat'];
        $Save_path = '../certificate/' . $Certificate_code;

        $Connect_1c = new Request_to_1c();
        $Path_file_certificate = $Connect_1c->get_file('GetCertificate',$Fields,$Save_path,'#');
        
        $array_url_code = ['Certificate_code'=>$Certificate_code,'url'=> $Path_file_certificate];
            
        echo json_encode($array_url_code);
        exit();
    }

?>