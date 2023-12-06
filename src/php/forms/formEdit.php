<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Edição</title>
    <link rel="stylesheet" type="text/css" href="../../css/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="src/images/icon_list.png">
</head>
<body>

    <br>

    <dialog class="dialog_edit" id="editForm">
        <div class="div_edit">
            <button id="btn_close_edit" onclick='window.history.go(-1);'>X</button>
            <form action="saveEdit.php" method="post">
                <fieldset id="fiel_title">
                    <legend id="form_title"><h2>Formulário de Edição</h2></legend>
                    <br>
                    <input type="text" value="<?=$_POST["edit_id"]?>" name="id_d" id="id_d" class="inputUser" required>
                    <div>
                        <label for="name_d" class="labelInput"><strong>Name: </strong></label>
                        <input type="text" value="<?=$_POST["edit_name"]?>" name="name_d" id="name_d" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <label for="email_d" class="labelInput"><strong>Email: </strong></label>
                        <input type="text" value="<?=$_POST["edit_email"]?>" name="email_d" id="email_d" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <label for="age_d" class="labelInput"><strong>Age: </strong></label>
                        <input type="text" value="<?=$_POST["edit_age"]?>" name="age_d" id="age_d" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <label for="work_d" class="labelInput"><strong>Work: </strong></label>
                        <input type="text" value="<?=$_POST["edit_work"]?>" name="work_d" id="work_d" class="inputUser" required>
                    </div>
                    <br><br>
                    <div>
                        <input type="submit" name="submit" id="submit">
                    </div>
                </fieldset>
            </form>
        </div>
        <!--Lógica do Formulário de edição-->
        <script>editForm.showModal()</script> 
    </dialog>

</body>
</html>