<?php 
    declare(strict_types = 1);
    require_once('vendor/autoload.php');
    require_once('vendor/vlucas/phpdotenv/src/Dotenv.php');
    require_once('src/php/class/ConnectDB.php');

    /**
     * Biblioteca externa que permite a manipulação das variaveis de ambiente;
     * @author: R1TKILL;
     */
    $enviroments = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $enviroments -> load();
    
    $objSql = new ConnectDB();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manipulando dados do Banco com php</title>
    <link rel="stylesheet" type="text/css" href="src/css/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="src/images/icon_list.png">
</head>
<body>

    <!--Tabela inicial-->
    <div class="div_container">
        <h1 id="tb_title">Tabela de Pessoas</h1>
        <button id="btn_add" onclick='createForm.showModal();'>
            <i class="fa fa-user-plus" aria-hidden="true"></i>
        </button>
        <div class="tb_div">
            <table class="tb_container">
                <!--Cabeçaho-->
                <tr class="tb_header">
                    <th class="tb_header_row">Nome</th>
                    <th class="tb_header_row">Email</th>
                    <th class="tb_header_row">Idade</th>
                    <th class="tb_header_row">Profissão</th>
                    <th class="tb_header_row">Editar</th>
                    <th class="tb_header_row">Apagar</th>
                </tr>
                <!--Corpo-->
                <?php 
                    $returnSql = ($objSql -> readAllDates());

                    foreach ($returnSql as $resSQL) {
                        echo "
                            <tr class=\"tb_body\">
                                <form action=\"src/php/forms/formEdit.php\" method=\"post\">
                                    <input type=\"text\" class=\"editDates\" id=\"edit_id\" name=\"edit_id\" value=\"{$resSQL["id"]}\">
                                    <td class=\"tb_body_row\" id=\"name_{$resSQL["id"]}\">{$resSQL["name"]}</td>
                                    <input type=\"text\" class=\"editDates\" id=\"edit_name\" name=\"edit_name\" value=\"{$resSQL["name"]}\">         
                                    <td class=\"tb_body_row\" id=\"email_{$resSQL["id"]}\">{$resSQL["email"]}</td>
                                    <input type=\"text\" class=\"editDates\" id=\"edit_email\" name=\"edit_email\" value=\"{$resSQL["email"]}\">
                                    <td class=\"tb_body_row\" id=\"age_{$resSQL["id"]}\">{$resSQL["age"]}</td>
                                    <input type=\"text\" class=\"editDates\" id=\"edit_age\" name=\"edit_age\" value=\"{$resSQL["age"]}\">
                                    <td class=\"tb_body_row\" id=\"work_{$resSQL["id"]}\">{$resSQL["work"]}</td>
                                    <input type=\"text\" class=\"editDates\" id=\"edit_work\" name=\"edit_work\" value=\"{$resSQL["work"]}\">
                                    <td class=\"tb_body_row\"><button class=\"btn_edit\" id=\"btn_edit_{$resSQL["id"]}\"><i class=\"fas fa-pencil\"></i></button></td>
                                </form>
                                <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\">
                                    <td class=\"tb_body_row\"><button class=\"btn_remove\" id=\"btn_remove_{$resSQL["id"]}\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>
                                    <input type=\"text\" id=\"del_id\" name=\"del_id\" value=\"{$resSQL["id"]}\">
                                </form>
                            </tr>
                        ";
                    }

                    //Lógica de deletar clientes.
                    $delId = (int) $_POST["del_id"]; 
                    if(!empty($delId)){
                        $objSql -> deleteFilterDate($delId);
                        
                        #Recarregando o arquivo inicial.
                        header('Location: http://localhost:5555');
                    }
                ?>
            </table>
        </div>
    </div>

    <!--Formulário de cadastro-->
    <dialog class="dialog_create" id="createForm">
        <div class="div_create">
            <button id="btn_close_create" onclick='createForm.close();'>X</button>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <fieldset id="fiel_title">
                    <legend id="form_title"><h2>Formulário de Cadastro</h2></legend>
                    <br>
                    <div>
                        <label for="name_c" class="labelInput"><strong>Name: </strong></label>
                        <input type="text" name="name_c" id="name_c" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <label for="email_c" class="labelInput"><strong>Email: </strong></label>
                        <input type="text" name="email_c" id="email_c" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <label for="age_c" class="labelInput"><strong>Age: </strong></label>
                        <input type="text" name="age_c" id="age_c" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <label for="work_c" class="labelInput"><strong>Work: </strong></label>
                        <input type="text" name="work_c" id="work_c" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <input type="submit" name="submit" id="submit">
                    </div>
                </fieldset>
            </form>
        </div>
        <!--Lógica do Formulário de cadastro-->      
        <?php 
            $insertName = $_POST['name_c'];
            $insertEmail = $_POST['email_c'];
            $insertAge = $_POST['age_c'];                    
            $insertWork = $_POST['work_c'];

            if(!empty($insertName) && !empty($insertEmail) && !empty($insertAge) && !empty($insertWork)){
                $objSql -> insertDates(...[$insertName, $insertEmail, $insertAge, $insertWork]);          
                
                #Recarregar o arquivo limpando a os parâmetros da url.
                echo "<script>
                    var newURL = location.href.split(\"?\")[0];
                    window.history.pushState('object', document.title, newURL);
                    window.document.location.replace(\"http://localhost:5555\");
                </script>";
            }            
        ?>
    </dialog>

</body>
</html>