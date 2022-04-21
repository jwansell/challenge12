<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php
        echo $title ?? 'Base Title';
        ?>
    </title>
    <link rel="stylesheet" href="/src/css/style.css">
</head>
<body>
<div class="flex column">
    <header>
        <?php
        require __DIR__ . '/NavBar.php';
        ?>
    </header>

    <div id="errorMessage"></div>
    <div id="successMessage"></div>

    <main>
        <?php
        echo $slot ?? '<div class="warning">Missing HTML</div>';
        ?>
    </main>
</div>

<script src="/src/js/navbar.js"></script>
<script src="/src/js/base.js"></script>
</body>
</html>