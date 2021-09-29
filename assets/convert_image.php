<?php

    function convert($path_to_file){
       $image = new Imagick($path_to_file);
       $image->cropImage(250, 250, 30, 10);
       $image->writeImage($path_to_file);

    }

?>