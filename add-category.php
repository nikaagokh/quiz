<?php
require "./connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['name'];
    
    if (isset($_FILES['image'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];

        $upload_dir = 'public/images/';
        
        $upload_path = $upload_dir . basename($image_name);
        
        if (move_uploaded_file($image_tmp_name, $upload_path)) {
            $sql = "INSERT INTO categories (category_name, c_image_path) VALUES ('$category_name', '$image_name');";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            echo "<div style='color: green; font-weight: bold;' class='app-container'>პროდუქტი წარმატებით დაემატა</div>";
        } else {
            echo "ფაილი არ აიტვირთა";
        }
    } else {
        echo "აუცილებელია, რომ ატვირთოთ ფაილი";
    }
}
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
    <div class="app-container">
        <a class="back-button" href="/davaleba/index.php">
            <i class="material-symbols-outlined" style="color: black;">chevron_left</i>
            მთავარ გვერდზე
        </a>
        <form action="" method="post" enctype="multipart/form-data" style="display: flex; flex-direction:column; gap:0.5rem; width:400px;">
            <input type="text" name="name" class="napr-input-inner" autocomplete="off" placeholder="კატეგორიის სახელი">
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" name="submit" class="napr-button button-primary">დამატება</button>
        </form>
    </div>
</body>

</html>