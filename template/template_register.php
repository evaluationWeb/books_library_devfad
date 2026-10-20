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
    <?php include 'component/navbar.php'; ?>
    <main class="container-fluid">
        <h1>S'inscrire</h1>
        <form action="" method="post">
            <input type="text" name="firstname" placeholder="saisir votre Prénom">
            <!-- Block erreur de validation Prénom -->
            <?php if(isset($data["validation"]["firstname"])): ?>
                <?php foreach ($data["validation"]["firstname"] as $error) : ?>
                    <p><?=  htmlspecialchars($error->message, ENT_QUOTES, 'UTF-8');  ?></p>
                <?php endforeach ?>
            <?php endif ?>
            <input type="text" name="lastname" placeholder="saisir votre Nom">
            <!-- Block erreur de validation Nom -->
            <?php if(isset($data["validation"]["lastname"])): ?>
                <?php foreach ($data["validation"]["lastname"] as $error) : ?>
                    <p><?=  htmlspecialchars($error->message, ENT_QUOTES, 'UTF-8');  ?></p>
                <?php endforeach ?>
            <?php endif ?>
            <input type="text" name="email" placeholder="saisir votre Email">
            <!-- Block erreur de validation Email -->
            <?php if(isset($data["validation"]["email"])): ?>
                <?php foreach ($data["validation"]["email"] as $error) : ?>
                    <p><?=  htmlspecialchars($error->message, ENT_QUOTES, 'UTF-8');  ?></p>
                <?php endforeach ?>
            <?php endif ?>
            <input type="password" name="password" placeholder="saisir le mot de passe">
            <!-- Block erreur de validation Password -->
            <?php if(isset($data["validation"]["password"])): ?>
                <?php foreach ($data["validation"]["password"] as $error) : ?>
                    <p><?=  htmlspecialchars($error->message, ENT_QUOTES, 'UTF-8');  ?></p>
                <?php endforeach ?>
            <?php endif ?>
            <input type="password" name="confirm-password" placeholder="saisir le mot de passe">
            <input type="submit" value="Inscription" name="submit">
        </form>
        <!--Block erreur -->
        <p><?= htmlspecialchars($data["error"] ?? "", ENT_QUOTES, 'UTF-8') ?></p>
        <!--Block succes -->
        <p><?= htmlspecialchars($data["success"] ?? "", ENT_QUOTES, 'UTF-8') ?></p>
    </main>
</body>
</html>
