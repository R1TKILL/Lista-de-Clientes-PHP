<?php

    declare(strict_types = 1);
    require_once('../../../index.php');

    $editId = (int) $_POST["id_d"];   
    $editName = $_POST["name_d"];
    $editEmail = $_POST["email_d"];
    $editAge = $_POST["age_d"];
    $editWork = $_POST["work_d"];

    if(!empty($editId) && !empty($editName) && !empty($editEmail) && !empty($editAge) && !empty($editWork)){              
        $objSql -> updateFilterDate(...[$editId , $editName, $editEmail, $editAge, $editWork]);          

        #Recarregando o arquivo inicial.
        header('Location: http://localhost:5555');
    }

?>