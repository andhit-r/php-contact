<?php
// public/index.php

$name = $email = $message = '';
$nameErr = $emailErr = $messageErr = '';
$successMessage = '';
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    if (empty($_POST["name"])) {
        $nameErr = "Nama wajib diisi";
        $hasError = true;
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
        // Cek jika nama hanya mengandung huruf dan spasi
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Hanya huruf dan spasi yang diizinkan";
            $hasError = true;
        }
    }

    // Validasi Email
    if (empty($_POST["email"])) {
        $emailErr = "Email wajib diisi";
        $hasError = true;
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        // Cek format email yang valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
            $hasError = true;
        }
    }

    // Validasi Pesan
    if (empty($_POST["message"])) {
        $messageErr = "Pesan wajib diisi";
        $hasError = true;
    } else {
        $message = htmlspecialchars(trim($_POST["message"]));
        // Batasi panjang pesan
        if (strlen($message) > 500) {
            $messageErr = "Pesan terlalu panjang (maks. 500 karakter)";
            $hasError = true;
        }
    }

    // Jika tidak ada error, proses form
    if (!$hasError) {
        // Di sini Anda bisa menyimpan data ke database, mengirim email, dll.
        // Untuk contoh ini, kita hanya akan menampilkan pesan sukses.
        $successMessage = "Terima kasih, " . $name . "! Pesan Anda telah kami terima.";
        // Bersihkan input setelah sukses
        $name = $email = $message = '';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kontak Kami</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Kontak Kami</h2>

        <?php if ($successMessage): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php elseif ($hasError): ?>
            <div class="error-message">Mohon perbaiki kesalahan pada form.</div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
                <?php if ($nameErr): ?><div class="error-message"><?php echo $nameErr; ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <?php if ($emailErr): ?><div class="error-message"><?php echo $emailErr; ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="message">Pesan Anda:</label>
                <textarea id="message" name="message" required><?php echo $message; ?></textarea>
                <?php if ($messageErr): ?><div class="error-message"><?php echo $messageErr; ?></div><?php endif; ?>
            </div>

            <button type="submit">Kirim Pesan</button>
        </form>
    </div>
</body>
</html>