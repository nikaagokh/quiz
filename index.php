<?php
require "./connection.php";

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sql = "UPDATE categories SET category_name='$name' WHERE category_id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

if (isset($_GET['del'])) {
    $id = (int) $_GET['del'];
    $sql = "DELETE FROM categories WHERE category_id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}


$sql = "SELECT *
            FROM categories";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://napr-design.vercel.app/public/css/styles.css">
    <link rel="stylesheet" href="/final/public/css/styles.css">
</head>

<body>
    <div class="app-container" style="padding-bottom: 4rem;">
        <table class="napr-table" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ფოტო</th>
                    <th scope="col">სახელი</th>
                    <th scope="col">edit</th>
                    <th scope="col">delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $index => $category) : ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td>
                                <a href="/davaleba/product.php?category_id=<?=$category['category_id']?>">
                                    <img src="/davaleba/public/images/<?= $category['c_image_path'] ?>" height="50" width="80">
                                </a>
                            </td>
                            <td><?= $category['category_name'] ?></td>
                            <td class="edit-category-button">
                                <a href="?edit=<?= $category['category_id'] ?>">ცვლილება</a>
                            </td>
                            <td class="edit-category-button">
                                <a href="?del=<?= $category['category_id'] ?>">წაშლა</a>
                            </td>
                        </tr>
                    
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $sql = "SELECT * FROM categories WHERE category_id = $id";
            $stmte = $pdo->prepare($sql);
            $stmte->execute();

            $categori = $stmte->fetch(PDO::FETCH_ASSOC);
        ?>

            <form action="" method="post" style="display: flex; flex-direction:column; gap:0.5rem; width:400px;">
                <label>სახელი</label>
                <input type="text" name="name" class="napr-input-inner" autocomplete="off" value="<?= $categori['category_name'] ?>">
                <input type="hidden" name="id" value="<?= $categori['category_id'] ?>">
                <button name="edit" class="napr-button button-primary">ცვლილება</button>
            </form>
        <?php
        }
        ?>

    </div>

    <a href="/davaleba/add-category.php" class="napr-button button-primary" style="position: fixed; right:2rem;bottom:2rem;">დამატება</a>
</body>

</html>