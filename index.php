<?php include 'db.php'; ?>

<?php
// INSERT & UPDATE
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $tahun_rilis = $_POST['tahun_rilis'];
    $rating = $_POST['rating'];

    if ($_POST['submit'] == 'update') {
        $id = $_POST['id'];
        $conn->query("UPDATE film SET judul='$judul', genre='$genre', tahun_rilis='$tahun_rilis', rating='$rating' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO film (judul, genre, tahun_rilis, rating) VALUES ('$judul', '$genre', '$tahun_rilis', '$rating')");
    }

    header("Location: index.php");
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM film WHERE id=$id");
    header("Location: index.php");
}

// GET DATA FOR EDIT
$editMode = false;
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM film WHERE id=$id");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Film</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2><?= $editMode ? 'Update Data Film' : 'Tambah Film' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editMode ? $row['id'] : '' ?>">
        <label>Judul:</label>
        <input type="text" name="judul" value="<?= $editMode ? $row['judul'] : '' ?>" required>
        <label>Genre:</label>
        <input type="text" name="genre" value="<?= $editMode ? $row['genre'] : '' ?>" required>
        <label>Tahun Rilis:</label>
        <input type="number" name="tahun_rilis" value="<?= $editMode ? $row['tahun_rilis'] : '' ?>" required>
        <label>Rating (1–10):</label>
        <input type="number" name="rating" min="1" max="10" value="<?= $editMode ? $row['rating'] : '' ?>" required>
        <button class="submit-btn" type="submit" name="submit" value="<?= $editMode ? 'update' : 'insert' ?>">
            <?= $editMode ? 'Simpan Perubahan' : 'Tambah Film' ?>
        </button>
    </form>

    <hr>
    <h2>Daftar Film Favorit</h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="8">
        <tr style="background-color:#805ad5;color:white;">
            <th>No</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Tahun Rilis</th>
            <th>Rating</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $result = $conn->query("SELECT * FROM film ORDER BY id DESC");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['genre'] ?></td>
            <td><?= $row['tahun_rilis'] ?></td>
            <td><?= $row['rating'] ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>"><button class="update-btn">Update</button></a>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')"><button class="delete-btn">Hapus</button></a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
