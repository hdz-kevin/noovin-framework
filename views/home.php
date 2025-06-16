<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome to the Home Page</h1>

    <?php foreach (["Item 1", "Item 2", "Item 3"] as $item): ?>
        <h2><?= $item; ?></h2>
    <?php endforeach; ?>
</body>
</html>
