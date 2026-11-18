<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload CSV · {{ config('app.name', 'Warmtenet') }}</title>
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/upload.css">
    @vite(['resources/css/app.css', 'resources/css/Upload.css'])
</head>
<body class="energy-dashboard">
    <div class="dashboard-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('dashboard') }}" aria-label="Warmtenet dashboard">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M16 3.5c-4.1 5.2-8.5 9.4-8.5 15a8.5 8.5 0 0 0 17 0c0-5.6-4.4-9.8-8.5-15Z" fill="currentColor" opacity=".18"/>
                        <path d="M16 5.5c-3.5 4.5-7 8-7 13a7 7 0 0 0 14 0c0-5-3.5-8.5-7-13Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M12.5 19.5c.4 2 1.6 3.1 3.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="brand-copy"><strong>Warmte<span>Net</span></strong><small>ENERGIEBEHEER</small></span>
            </a>

            <div class="topbar-divider"></div>
            <div class="breadcrumb">
                <span>Overzicht</span>
                <span class="breadcrumb-slash">/</span>
                <strong><a href="{{ route('dashboard') }}">Dashboard</a></strong>
                <span class="breadcrumb-slash">/</span>
                <strong><x-nav-link href="/Upload" :active="request()->is('Upload')">Upload</x-nav-link></strong>
            </div>

            <div class="topbar-actions">
                <span class="connection-status"><span></span> Voorbeeldweergave</span>
                <div class="topbar-divider topbar-divider-small"></div>
                <div class="user-menu">
                    <span class="user-avatar">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout-button" type="submit" aria-label="Uitloggen" title="Uitloggen">
                            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M8 3H4.8A1.8 1.8 0 0 0 3 4.8v10.4A1.8 1.8 0 0 0 4.8 17H8m4-3 4-4-4-4m4 4H7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>
                </div>
            </div>
                </header>

        <main class="upload-main">
            <div class="upload-container">
                <h2>Upload CSV to Database</h2>
                <form action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label for="csv_file" class="csv-upload-label">
                        <img src="{{ asset('images/upload.png') }}" alt="Kies CSV bestand" class="upload-icon" />
                        <span id="file-text">Kies CSV bestand</span>
                    </label>

                    <input type="file" name="csv_file" id="csv_file" accept=".csv" required onchange="document.getElementById('file-text').innerText = this.files[0] ? this.files[0].name : 'Kies CSV bestand'">

                    <button type="submit" class="submit-btn">Upload and Import</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
