<?php
$adm_uri = HOME_URI . '/';
$add_uri = $adm_uri . 'add';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'delete/';
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
        <h2>Listagem de cadastros</h2>
        <div class="form-group ">
            <a href="<?php echo $add_uri ?>" class="btn btn-info" role="button">Adicionar</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th> Id </th>
                    <th> Nome </th>
                    <th> Sobrenome </th>
                    <th> Data Nascimento </th>
                    <th> Gênero </th>
                    <th colspan="2"> </th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)) : ?>
                    <tr>
                        <th style="text-align: center;" colspan="5">Sem Cadastros</th>
                    </tr>
                <?php else : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['birth_day']; ?></td>
                            <td><?php echo $user['gender']; ?></td>
                            <td>
                                <a href="<?php echo $edit_uri . $user['id'] ?>">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo $delete_uri .  $user['id'] ?>">
                                    Apagar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>