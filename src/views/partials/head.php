<?php

function getStyles($title) {
    return match(true) {
        $title == 'Inicio' => '<link rel="stylesheet" type="text/css" href="public/css/welcome.css">',
        $title == 'Alumnos' => '<link rel="stylesheet" type="text/css" href="public/css/tabladatos.css">',
        default => ''
    };
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="public/css/menu.css">
    <?= getStyles($title) ?>
</head>