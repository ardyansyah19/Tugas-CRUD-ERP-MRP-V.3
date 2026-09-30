<?php
/**
 * Layout bersama semua halaman aplikasi (wajib login).
 * Pemakaian:  page_start('Judul', 'menu-aktif');  ... isi ...  page_end(['js/erp-core.js', 'js/halaman.js']);
 */
require_once __DIR__ . '/../config/config.php';

function nav_menu(): array
{
    return [
        'Akademik' => [
            'dashboard' => ['Dashboard', 'dashboard.php'],
            'mahasiswa' => ['Mahasiswa', 'index.php'],
            'kelas'     => ['Kelas', 'kelas.php'],
        ],
        'Master' => [
            'item'     => ['Item & BOM', 'item.php'],
            'supplier' => ['Supplier', 'supplier.php'],
        ],
        'Perencanaan' => [
            'kebutuhan' => ['Kebutuhan (MPS)', 'kebutuhan.php'],
            'mrp'       => ['MRP', 'mrp.php'],
        ],
        'Operasional' => [
            'po'   => ['Purchase Order', 'po.php'],
            'wo'   => ['Work Order', 'wo.php'],
            'stok' => ['Stok', 'stok.php'],
        ],
    ];
}

function page_start(string $title, string $active): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
    $token = csrf_token();
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?> - <?= htmlspecialchars(APP_NAME) ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <input type="hidden" id="csrf_token" value="<?= htmlspecialchars($token) ?>">
  <div class="container">
    <nav class="topnav">
      <span class="brand">MRP-ERP</span>
      <?php foreach (nav_menu() as $grup => $items): ?>
        <span class="grp"><?= htmlspecialchars($grup) ?></span>
        <?php foreach ($items as $key => [$label, $href]): ?>
          <a href="<?= $href ?>" class="<?= $key === $active ? 'active' : '' ?>"><?= htmlspecialchars($label) ?></a>
        <?php endforeach; ?>
      <?php endforeach; ?>
      <span class="spacer"></span>
      <span class="who"><?= htmlspecialchars($_SESSION['username']) ?></span>
      <button id="btnDarkMode" class="btn btn-secondary btn-sm" title="Ganti tema">🌓</button>
      <button id="btnLogout" class="btn btn-secondary btn-sm">Keluar</button>
    </nav>
<?php
}

function page_end(array $scripts = []): void
{
    ?>
  </div>
  <div id="toastContainer" class="toast-container"></div>
  <?php foreach ($scripts as $src): ?>
  <script src="<?= htmlspecialchars($src) ?>"></script>
  <?php endforeach; ?>
</body>
</html>
<?php
}
