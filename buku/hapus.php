<?php
require __DIR__ . '/../includes/auth.php';   // harus login dulu
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if (($_SESSION['role'] ?? '') !== 'admin') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Hanya admin yang boleh menghapus buku.'];
    header('Location: list.php');
    exit;
}

// Sengaja hanya menerima POST (bukan GET) agar penghapusan tidak bisa
// dipicu tanpa sengaja lewat link/preview crawler.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

$id = (int) ($_POST['id'] ?? 0);
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.'];
    } catch (PDOException $e) {
        if ($e->getCode() === '23503') {
            $pesan = 'Buku tidak bisa dihapus karena masih tercatat di riwayat peminjaman.';
        } else {
            error_log('Gagal menghapus buku: ' . $e->getMessage());
            $pesan = 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.';
        }
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesan];
    }
}

header('Location: list.php');
exit;
