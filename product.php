<?php
require "./connection.php";
$category_id = (int) $_GET['category_id'];

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $avail = $_POST['available'];
    $cond = $_POST['condition'];
    $price = $_POST['price'];
    $sql = "UPDATE products SET title='$title', avail='$avail', cond='$cond', price='$price' WHERE product_id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

if (isset($_GET['del'])) {
    $id = (int) $_GET['del'];
    $sql = "DELETE FROM products WHERE product_id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

$sql = "SELECT *
            FROM products
            WHERE category_id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$category_id]);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://napr-design.vercel.app/public/css/styles.css">
    <link rel="stylesheet" href="/final/public/css/styles.css">
</head>

<body>
    <div class="app-container">
        <a class="back-button" href="/davaleba/index.php">
            <i class="material-symbols-outlined" style="color: black;">chevron_left</i>
            უკან
        </a>

        <?php if (count($products) > 0) : ?>
            <table class="napr-table" style="width: 100%; margin-top:2rem;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ფოტო</th>
                        <th scope="col">სახელი</th>
                        <th scope="col">მარაგები</th>
                        <th scope="col">მდგომარეობა</th>
                        <th scope="col">ფასი</th>
                        <th scope="col">edit</th>
                        <th scope="col">delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $product) : ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td>
                                <img src="/davaleba/public/images/<?= $product['image_path'] ?>" height="50" width="80">
                            </td>
                            <td><?= $product['title'] ?></td>
                            <td><?= $product['avail'] ?></td>
                            <td><?= $product['cond'] ?></td>
                            <td><?= $product['price'] ?> ₾</td>
                            <td class="edit-category-button">
                                <a href="?category_id=<?= $category_id ?>&edit=<?= $product['product_id'] ?>">ცვლილება</a>
                            </td>
                            <td class="edit-category-button">
                                <a href="?category_id=<?= $category_id ?>&del=<?= $product['product_id'] ?>">წაშლა</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div style="display: flex; flex-direction:column;">
                <div>ამ კატეგორიაში პროდუქტები ვერ მოიძებნა!</div>
                <b><a href="/davaleba/add-product.php?category_id=<?= $category_id ?>">პროდუქტის დამატება</a></b>
            </div>
        <?php endif; ?>

        <?php
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $sql = "SELECT * FROM products WHERE product_id = $id";
            $stmte = $pdo->prepare($sql);
            $stmte->execute();

            $producti = $stmte->fetch(PDO::FETCH_ASSOC);
        ?>

            <form action="" method="post" style="display: flex; flex-direction:column; gap:0.5rem; width:400px;">
                <label>სახელი</label>
                <input type="text" name="title" class="napr-input-inner" autocomplete="off" value="<?= $producti['title'] ?>">
                <label>მარაგები</label>
                <input type="text" name="available" class="napr-input-inner" autocomplete="off" value="<?= $producti['avail'] ?>">
                <label>მდგომარეობა</label>
                <input type="text" name="condition" class="napr-input-inner" autocomplete="off" value="<?= $producti['cond'] ?>">
                <label>ფასი</label>
                <input type="text" name="price" class="napr-input-inner" autocomplete="off" value="<?= $producti['price'] ?>">
                <input type="hidden" name="id" value="<?= $producti['product_id'] ?>">
                <button name="edit" class="napr-button button-primary">ცვლილება</button>
            </form>
        <?php
        }
        ?>
    </div>

</body>

</html>