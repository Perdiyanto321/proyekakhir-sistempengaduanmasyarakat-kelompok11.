<?php

$activePage = $activePage ?? '';

$navItems = [
    'dashboard'  => ['href' => 'dashboard_user.php',       'label' => 'Dashboard',      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'],
    'buat'       => ['href' => 'buatlaporan.php',           'label' => 'Buat Laporan',   'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>'],
    'laporan'    => ['href' => 'kelola_laporan_user.php',   'label' => 'Laporan Saya',   'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
    'tanggapan'  => ['href' => 'lihat_tanggapan.php',       'label' => 'Tanggapan',      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>'],
    'profil'     => ['href' => 'detail_user.php',           'label' => 'Profil Saya',    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'],
];

function renderNavItemUser($key, $item, $activePage) {
    $isActive = $key === $activePage;
    $base     = 'flex items-center gap-3 px-5 py-3 rounded-2xl transition duration-200 text-sm font-medium';
    $cls      = $isActive
        ? "$base bg-emerald-600 text-white active-nav"
        : "$base text-slate-300 hover:bg-slate-800 hover:text-white";
    echo "<a href=\"{$item['href']}\" class=\"$cls\">{$item['icon']}<span>{$item['label']}</span></a>";
}
?>

<!-- ═══ DESKTOP SIDEBAR ════════════════════════════════════════════════ -->
<aside class="hidden lg:flex flex-col w-64 bg-slate-900 text-white min-h-screen sticky top-0 h-screen">

    <div class="p-6 border-b border-slate-800">
        <h1 class="text-2xl font-bold text-emerald-400 sidebar-brand">PengaduanKu</h1>
        <p class="text-slate-400 text-xs mt-1">Dashboard User</p>
    </div>

    <nav class="flex flex-col gap-1 p-4 flex-1">
        <?php foreach ($navItems as $key => $item) renderNavItemUser($key, $item, $activePage); ?>
    </nav>

    <div class="p-4 border-t border-slate-800 space-y-1">

        <button
            data-theme-toggle
            class="flex items-center gap-3 w-full px-5 py-3 rounded-2xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition duration-200">
            <span data-theme-icon>🌙</span>
            <span data-theme-label>Dark Mode</span>
        </button>

        <a href="../auth/logout.php"
            class="flex items-center gap-3 px-5 py-3 rounded-2xl text-sm font-medium text-slate-300 hover:bg-red-500/20 hover:text-red-400 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>Logout</span>
        </a>

    </div>

</aside>

<!-- ═══ MOBILE TOPBAR ══════════════════════════════════════════════════ -->
<div class="lg:hidden fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between card">

    <button id="hamburgerBtn" aria-label="Buka menu"
        class="p-2 rounded-xl hover:bg-slate-100 transition text-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <h1 class="text-lg font-bold text-emerald-500">PengaduanKu</h1>

    <button data-theme-toggle aria-label="Toggle theme"
        class="p-2 rounded-xl hover:bg-slate-100 transition">
        <span data-theme-icon class="text-lg">🌙</span>
    </button>

</div>

<!-- ═══ MOBILE SIDEBAR OVERLAY ════════════════════════════════════════ -->
<div id="sidebarOverlay"
    class="lg:hidden fixed inset-0 z-40 bg-black/50 opacity-0 pointer-events-none transition-opacity duration-300">
</div>

<!-- ═══ MOBILE SIDEBAR DRAWER ═════════════════════════════════════════ -->
<div id="mobileSidebar"
    class="lg:hidden fixed top-0 left-0 z-50 h-full w-72 bg-slate-900 text-white flex flex-col -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl">

    <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-emerald-400 sidebar-brand">PengaduanKu</h1>
            <p class="text-slate-400 text-xs mt-0.5">Dashboard User</p>
        </div>
        <button id="sidebarCloseBtn" aria-label="Tutup menu"
            class="p-2 rounded-xl hover:bg-slate-800 transition text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="flex flex-col gap-1 p-4 flex-1">
        <?php foreach ($navItems as $key => $item) renderNavItemUser($key, $item, $activePage); ?>
    </nav>

    <div class="p-4 border-t border-slate-800 space-y-1">

        <button
            data-theme-toggle
            class="flex items-center gap-3 w-full px-5 py-3 rounded-2xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition duration-200">
            <span data-theme-icon>🌙</span>
            <span data-theme-label>Dark Mode</span>
        </button>

        <a href="../auth/logout.php"
            class="flex items-center gap-3 px-5 py-3 rounded-2xl text-sm font-medium text-slate-300 hover:bg-red-500/20 hover:text-red-400 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>Logout</span>
        </a>

    </div>

</div>
