<?php
$bars = [10,20,40,10,15,5,5,5,5,5,5,5,5,7,8,9,10,11,25,50,40,30,20,10];
$parts = [45, 30, 15, 10];
$names = ['Geothermal', 'Residual heat', 'Biomass', 'Gas boiler'];
$colors = ['#2de390', '#19d3e6', '#ffb020', '#ff6a1a'];
$acc = 0; $stops = [];
foreach ($parts as $i => $p) {$stops[] = $colors[$i] . ' ' . $acc . '% ' . ($acc += $p) . '%';}
$now = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Energie dashboard · {{ config('app.name', 'Warmtenet') }}</title>
    @vite
    <link rel="stylesheet" href="../css/app.css">
</head>
<body class="energy-dashboard" x-data="{ activeLayer: 'warmte', selectedPoint: 'centrale' }">
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
            <div class="breadcrumb"><span>Overzicht</span><span class="breadcrumb-slash">/</span><strong>Dashboard</strong><span class="breadcrumb-slash">/</span><strong> <x-nav-link href="/Upload" :active="request()->is('Upload')">Upload</x-nav-link></strong></div>
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

        <main class="dashboard-main">

            <div class="dashboard-grid">
                <aside class="info-column" aria-label="Netwerkinformatie">
                    <div class="panel">
                        <div class="mono">Generated heat</div>
                        <div class="chart">
                            <?php foreach ($bars as $i => $h) echo '<span class="' . ($i > 14 ? 'f' : '') . '" style="height:' . $h . '%"></span>'; ?>
                        </div>
                        <div class="mono" style="display:flex; justify-content:space-between; margin-top:8px"><span>06:00</span><span>12:00</span><span>18:00</span><span>Now</span></div>
                    </div>
                    <div class="panel">
                        <div class="mono">Heat distribution</div>
                        <div class="circle" style="background:conic-gradient(<?= implode(',', $stops) ?>)"></div>
                        <div class="dist">
                            <?php foreach ($parts as $i => $p): ?>
                                <div class="row">
                                    <i style="background:<?= $colors[$i] ?>"></i>
                                    <span><?= $names[$i] ?></span>
                                    <span class="pct"><?= $p ?>%</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </aside>

                <section class="map-card" aria-label="Kaart van het energienetwerk">
                    <div class="map-canvas" x-data="energyMap">
                        <div class="map-viewport" x-ref="map" role="application" aria-label="Interactieve kaart van Leerparkpromenade in Dordrecht"></div>
                        <svg class="map-art mock-map" :class="{ 'layer-pipes': activeLayer === 'leidingen', 'layer-addresses': activeLayer === 'aansluitingen' }" :style="{ transform: 'scale(' + zoom + ')' }" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                            <rect width="1200" height="800" fill="#edf1e9"/>
                            <path d="M-60 128 115 42l84 84-58 100L5 260ZM284 36l120-42 94 98-57 105-124-33ZM794-21l140 42-16 114-116 32-76-91ZM1007 208l152-34 91 96-45 117-179 20-67-98ZM-30 585l163-42 90 81-34 142-176 39ZM920 601l136-74 159 84-22 142-188 55-115-92Z" fill="#dfe9d9"/>
                            <path d="M337 505c89-60 157-31 228-66s129-78 235-52 155 79 253 36 153-25 225-78" fill="none" stroke="#c7e4e6" stroke-width="72" stroke-linecap="round"/>
                            <path d="M337 505c89-60 157-31 228-66s129-78 235-52 155 79 253 36 153-25 225-78" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
                            <g fill="#e2e8de">
                                <path d="m92 319 111-53 77 28-6 69-124 44-68-35Z"/><path d="m277 286 107-38 82 29 10 79-107 43-97-32Z"/>
                                <path d="m524 267 101-26 67 38-18 83-106 28-65-43Z"/><path d="m735 200 112-30 80 46-17 72-119 27-69-44Z"/>
                                <path d="m128 470 89-39 97 33 12 73-102 42-94-41Z"/><path d="m477 447 97-52 91 27 3 72-101 45-85-31Z"/>
                                <path d="m753 403 99-55 82 23 25 77-113 42-88-28Z"/><path d="m1034 448 103-29 89 53-16 79-116 27-68-49Z"/>
                                <path d="m374 654 103-43 88 38-11 78-123 33-74-37Z"/><path d="m653 617 111-33 79 50-18 78-107 28-78-47Z"/>
                            </g>
                            <g fill="#f8faf6" stroke="#d7dfd4" stroke-width="2">
                                <path d="m48 353 93-43 29 12-10 45-84 39-31-16Z"/><path d="m165 296 84-33 33 13-9 44-75 31-37-15Z"/>
                                <path d="m309 311 79-30 37 13-3 43-84 33-30-13Z"/><path d="m554 286 70-18 31 16-11 43-72 20-27-19Z"/>
                                <path d="m785 225 83-20 29 18-11 38-84 21-26-18Z"/><path d="m156 484 62-27 39 13-4 38-64 25-35-16Z"/>
                                <path d="m497 456 72-39 36 11v37l-72 34-34-12Z"/><path d="m784 415 72-39 32 10 10 37-77 29-34-11Z"/>
                                <path d="m1056 458 70-20 39 24-5 39-75 18-39-27Z"/><path d="m395 666 69-30 37 16-5 40-77 23-32-16Z"/>
                                <path d="m681 628 75-23 35 22-12 42-72 18-34-21Z"/>
                            </g>
                            <g fill="none" stroke="#fff" stroke-linecap="round">
                                <path d="M-30 298 123 241l155 50 146-60 122 42 120-47 159 11 133-52 147 31 133-47" stroke-width="19"/>
                                <path d="M23 547 159 415l152 31 113-95 122 46 145-98 120 18 143-108 128 57 142-40" stroke-width="18"/>
                                <path d="m88 12 44 185-31 157 55 130-26 175 60 157M263-10l20 166-48 141 49 150-21 183 49 178M462-10l-23 160 26 143-33 132 30 139-22 209M691-5l-33 162 47 153-28 137 42 136-9 220M916-15l29 171-47 144 33 138-24 152 51 203M1090-10l-42 186 32 159-30 139 40 158-24 176" stroke-width="16"/>
                            </g>
                            <g fill="none" stroke="#d3d9d0" stroke-width="2">
                                <path d="M-30 298 123 241l155 50 146-60 122 42 120-47 159 11 133-52 147 31 133-47"/>
                                <path d="M23 547 159 415l152 31 113-95 122 46 145-98 120 18 143-108 128 57 142-40"/>
                                <path d="m88 12 44 185-31 157 55 130-26 175 60 157M263-10l20 166-48 141 49 150-21 183 49 178M462-10l-23 160 26 143-33 132 30 139-22 209M691-5l-33 162 47 153-28 137 42 136-9 220M916-15l29 171-47 144 33 138-24 152 51 203M1090-10l-42 186 32 159-30 139 40 158-24 176"/>
                            </g>
                            <g fill="#8ca58a" opacity=".72">
                                <circle cx="209" cy="111" r="8"/><circle cx="229" cy="124" r="5"/><circle cx="680" cy="215" r="7"/><circle cx="696" cy="228" r="5"/>
                                <circle cx="1018" cy="102" r="8"/><circle cx="1038" cy="118" r="5"/><circle cx="370" cy="580" r="9"/><circle cx="390" cy="595" r="5"/>
                                <circle cx="875" cy="666" r="8"/><circle cx="893" cy="679" r="5"/><circle cx="1104" cy="686" r="9"/><circle cx="1123" cy="700" r="5"/>
                            </g>
                            <g class="map-labels" fill="#89958a" font-family="Arial, sans-serif" font-size="16" font-weight="600" letter-spacing="1.5">
                                <text x="88" y="223">PARKZICHT</text><text x="474" y="231">CENTRUM</text><text x="830" y="150">NOORD</text>
                                <text x="71" y="636">WESTERKWARTIER</text><text x="847" y="583">OOSTERPARK</text>
                                <text x="458" y="397" fill="#82acb0" font-size="13">SINGEL</text>
                            </g>
                            <g class="energy-lines" fill="none" stroke="#ee9c54" stroke-width="7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M207 562 285 502 354 519 429 452 487 457 535 403 603 418 664 363 728 383 796 330 851 341 922 292 978 312 1033 269"/>
                                <path d="M487 457 481 391 517 326 508 260M664 363 654 300 683 248M796 330 819 270 793 203M851 341 869 412 929 453 982 443M603 418 616 488 569 545 578 610M354 519 338 588 384 656"/>
                            </g>
                            <g fill="none" stroke="#f4c38f" stroke-width="2" stroke-dasharray="4 9" opacity=".9">
                                <path d="M207 562 285 502 354 519 429 452 487 457 535 403 603 418 664 363 728 383 796 330 851 341 922 292 978 312 1033 269"/>
                            </g>
                        </svg>

                        <div class="map-controls">
                            <div class="layer-control" role="group" aria-label="Kaartlaag selecteren">
                                <button type="button" :class="{ 'layer-active': activeLayer === 'warmte' }" @click="activeLayer = 'warmte'">
                                    <span class="layer-dot layer-dot-heat"></span> Warmtenet
                                </button>
                                <button type="button" :class="{ 'layer-active': activeLayer === 'leidingen' }" @click="activeLayer = 'leidingen'">
                                    <span class="layer-dot layer-dot-pipe"></span> Leidingen
                                </button>
                                <button type="button" :class="{ 'layer-active': activeLayer === 'aansluitingen' }" @click="activeLayer = 'aansluitingen'">
                                    <span class="layer-dot layer-dot-home"></span> Aansluitingen
                                </button>
                            </div>
                        </div>

                        <div class="map-marker marker-central" x-show="activeLayer !== 'aansluitingen'" role="button" tabindex="0" aria-label="Warmtecentrale bekijken" @click="selectedPoint = 'centrale'" @keydown.enter="selectedPoint = 'centrale'" :class="{ 'marker-selected': selectedPoint === 'centrale' }">
                            <span class="marker-pulse"></span><span class="marker-core marker-core-central"><svg viewBox="0 0 20 20" fill="none"><path d="M4 16V8l3-2v3l3-2v3l3-2v8M3 16h14M7 16v-3h3v3" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg></span>
                            <span class="marker-tooltip">Warmtecentrale</span>
                        </div>
                        <div class="map-marker marker-one" x-show="activeLayer !== 'leidingen'" role="button" tabindex="0" aria-label="Aansluiting Parklaan bekijken" @click="selectedPoint = 'parklaan'" @keydown.enter="selectedPoint = 'parklaan'" :class="{ 'marker-selected': selectedPoint === 'parklaan' }">
                            <span class="marker-core marker-core-home"><svg viewBox="0 0 20 20" fill="none"><path d="m3.5 9 6.5-5 6.5 5v7h-5v-4h-3v4h-5V9Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg></span>
                        </div>
                        <div class="map-marker marker-two" x-show="activeLayer !== 'leidingen'" role="button" tabindex="0" aria-label="Aansluiting Singel bekijken" @click="selectedPoint = 'singel'" @keydown.enter="selectedPoint = 'singel'" :class="{ 'marker-selected': selectedPoint === 'singel' }">
                            <span class="marker-core marker-core-home"><svg viewBox="0 0 20 20" fill="none"><path d="m3.5 9 6.5-5 6.5 5v7h-5v-4h-3v4h-5V9Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg></span>
                        </div>
                        <div class="map-marker marker-three" x-show="activeLayer !== 'leidingen'" role="button" tabindex="0" aria-label="Aansluiting Oosterpark bekijken" @click="selectedPoint = 'oosterpark'" @keydown.enter="selectedPoint = 'oosterpark'" :class="{ 'marker-selected': selectedPoint === 'oosterpark' }">
                            <span class="marker-core marker-core-home"><svg viewBox="0 0 20 20" fill="none"><path d="m3.5 9 6.5-5 6.5 5v7h-5v-4h-3v4h-5V9Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg></span>
                        </div>

                        <div class="map-detail" x-show="selectedPoint" x-cloak>
                            <button class="map-detail-close" type="button" aria-label="Details sluiten" @click="selectedPoint = null">×</button>
                            <span class="detail-type"><span></span> <span x-text="selectedPoint === 'centrale' ? 'WARMTEBRON' : 'AANSLUITING'"></span></span>
                            <strong x-text="selectedPoint === 'centrale' ? 'Warmtecentrale' : (selectedPoint === 'parklaan' ? 'Parklaan 12' : (selectedPoint === 'singel' ? 'Singel 48' : 'Oosterpark 6'))"></strong>
                            <span x-show="selectedPoint === 'centrale'" class="detail-reading">Aanvoertemperatuur <b>78,4 °C</b></span>
                            <span x-show="selectedPoint !== 'centrale'" class="detail-reading">Aansluiting <b>Actief</b></span>
                        </div>

                        <div class="map-attribution">Schematische netwerkkaart · voorbeeldweergave</div>
                    </div>

                    <div class="map-footer">
                        <div class="map-footer-right"><span class="status-dot"></span> Netwerkstatus <span class="footer-divider"></span> <time>{{ now()->locale('nl')->translatedFormat('H:i · l j F Y') }}</time></div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
