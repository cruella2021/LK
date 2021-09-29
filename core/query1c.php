<?php

class Request_to_1c{

    public $login = USER_1C;
    public $password = PASS_1C;
    public $url = 'http://' . IP_SERVER_1C . URL_1C;

    public function response($path,$fields = array()){

        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode("$this->login:$this->password"),
        );
        
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_URL,$this->url . $path);
        curl_setopt($curl, CURLOPT_PORT, 80);
        curl_setopt($curl, CURLOPT_POST, true);
        if (!empty($fields)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        }
        $json_response = json_decode(curl_exec($curl));
        
        curl_close($curl);
        

        return $json_response;
    }

  
    public function get_file($url_path,$fields = array(),$save_path,$defaul){

        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode("$this->login:$this->password"),
        );
        
        $fp = fopen($save_path, 'w');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_URL,$this->url . $url_path);
        curl_setopt($curl, CURLOPT_PORT, 80);
        curl_setopt($curl, CURLOPT_POST, true);
        if (!empty($fields)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        }
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_exec($curl);
        fclose($fp);

        

        $content_type = curl_getinfo($curl)['content_type'];
        curl_close($curl);

        if ($content_type == 'application/image'){
            return $save_path;
        }else{
            unlink($save_path);
            return $defaul;
        }

    }
    /*
    private function change_size($path_to_file){
        //Откажемся от этого
        $inFile = $path_to_file;
        $outFile = $path_to_file. 'new';
        $image = new Imagick($inFile);
        $image->cropImage(250, 250, 30, 10);
        $image->writeImage($outFile);

    }
  */  

}


?>