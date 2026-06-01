<?php
$pageTitle = $pageTitle ?? 'PengaduanKu';
$assetBase = $assetBase ?? '../assets';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle; ?> – PengaduanKu</title>

<script>
    function() {
        var t = localStorage.getItem('pengaduanku_theme');
        if (t === 'dark') document.documentElement.classList.add('dark');
    }();
</script>

<link rel="stylesheet" href="<?= $assetBase; ?>/css/theme.css">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
    }
</script>

<style>
    body { 
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; 
    }
    .no-transition * { 
        transition: none !important; 
    }
</style>

<script src="<?= $assetBase; ?>/js/app.js"></script>
