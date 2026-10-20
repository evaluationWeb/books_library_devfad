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
        <section>
            <!-- Block liste des catégorie -->
            <?php foreach ($data ?? [] as $category): ?>
                <article>
                    <h2><?= htmlspecialchars($category->getId(), ENT_QUOTES, 'UTF-8') ?></h2>
                    <p><?= htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8') ?></p>
                </article>
            <?php endforeach ?>
        </section>
    </main>
</body>

</html>