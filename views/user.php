<?php
$adm_uri = HOME_URI . '/';
$delete_uri = $adm_uri . 'delete/';
$title = !empty($user) ? 'Editar Usuário' : 'Cadastro do usuário';
$action = !empty($user) ? $adm_uri . 'update/' . $user['id'] : $adm_uri . 'insert';
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <?php echo $message ?>
        <div class="form-group col-md-12">
            <a href="<?php echo $adm_uri ?>">
                Voltar para lista
            </a>
        </div>
        <h2 class="col-sm-12"><?php echo $title ?></h2>
        <form method="post" action="<?php echo $action ?>" onsubmit="return checkForm()">
            <div class="form-group col-md-6">
                <label for="first_name">Nome:</label>
                <input name="first_name" type="text" value="<?php !empty($user['first_name']) ? print_r($user['first_name']) : '' ?>" required class="form-control" id="first_name" placeholder="Nome">
            </div>
            <div class="form-group  col-md-6">
                <label for="last_name">Sobrenome:</label>
                <input name="last_name" type="text" value="<?php !empty($user['last_name']) ? print_r($user['last_name']) : '' ?>" required class="form-control" id="last_name" placeholder="Sobrenome">
            </div>
            <div class="form-group col-md-6">
                <label for="birth_day">Nascimento:</label>
                <input name="birth_day" type="date" value="<?php !empty($user['birth_day']) ? print_r($user['birth_day']) : '' ?>" required class="form-control" id="birth_day" min="1910-01-01">
            </div>
            <div class="form-group col-md-6">
                <label for="gender">Gênero:</label>
                <select name="gender" class="form-control" required id="gender">
                    <option value=''>Selecione</option>
                    <option <?php !empty($user['gender']) && $user['gender'] === 'Feminino' ? print_r('selected') : '' ?> value="Feminino">Feminino</option>
                    <option <?php !empty($user['gender']) && $user['gender'] === 'Masculino' ? print_r('selected ') : '' ?>value="Masculino">Masculino</option>
                    <option <?php !empty($user['gender']) && $user['gender'] === 'Outro' ? print_r('selected') : '' ?>value="Outro">Outro</option>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <input type="submit" class="btn btn-info" value="Salvar">
                <?php
                if (!empty($user)) {
                    print_r('<a href="' . $delete_uri . $user['id'] . '" role="button"class="btn btn-danger">Deletar</a>');
                }
                ?>
            </div>
        </form>
    </div>
    <script>
        function checkForm() {
            if ($("#last_name").val().trim() == '') {
                alert("Favor inserir nome");
                $("#first_name").focus();
                return false;
            }
            if ($("#last_name").val().trim() == '') {
                alert("Favor inserir sobrenome");
                $("#last_name").focus();
                return false;
            }
            if ($("#birth_day").val().trim() == '') {
                alert("Favor inserir a data de nascimento");
                $("#birth_day").focus();
                return false;
            }
            if ($("#gender").val().trim() == '') {
                alert("Favor selecionar o gênero");
                $("#gender").focus();
                return false;
            }
        }
    </script>
</body>

</html>