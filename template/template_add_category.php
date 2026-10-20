<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <?php include 'component/navbar.php' ?>
    <main class="container-fluid">
        <h1>Ajouter une categorie</h1>
        <form action="" method="post">
            <input type="text" name="category_name" placeholder="Saisir le nom de la categorie">
            <?php foreach ($data[0]["validation"] ?? [] as $key => $value): ?>
                <p><?= $value[0]->message ?></p>
            <?php endforeach ?>
            <input type="submit" value="Ajouter" name="submit">
        </form>
        <p><?= $data[0]["msg"] ?? "" ?></p>
        <p><?= $data[0]["success"] ?? "" ?></p>
    </main>
</body>

</html>