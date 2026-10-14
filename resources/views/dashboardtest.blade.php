<?php
$bars = [10,20,40,10,15,5,5,5,5,5,5,5,5,7,8,9,10,11,25,50,40,30,20,10];
$nodes = [['DF MAIN-01', 98.2, '#10a100'], ['LEERPARK-02', 76.4, '#fff020'], ['MERWEDE-04', 42.1, '#ff6a1a']];
$load = [['Industrial', 42, '#ff8000'], ['Residential', 30, '#fff020'], ['Institutional', 28, '#10a100']];
$now = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));
?>
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ThermalGrid</title>
    <style>
      :root { --bg:#171c2a; --panel:#10101a; --line:#223344; --txt:#e8eef4; --mut:#7c8a98; --green:#2de390; --orange:#ff6a1a; --yellow:#ffb020; --cyan:#19d3e6; }
      * { box-sizing:border-box; margin:0 }
      body { background:var(--bg); color:var(--txt); font:14px/1.4 system-ui,sans-serif; }
      .mono { font-family:ui-monospace,Menlo,monospace; letter-spacing:.06em; text-transform:uppercase; font-size:11px; color:var(--mut); }
      header { display:flex; align-items:center; gap:16px; padding:14px 24px; border-bottom:1px solid var(--line); }
      .logo { width:42px; height:42px; border-radius:8px; background:var(--green); display:grid; place-items:center; color:#052; font-weight:800; }
      header h1 { font-size:17px; font-weight:800; }
      .sp { flex:1 }
      select { background:var(--panel); color:var(--txt); border:1px solid var(--line); border-radius:8px; padding:10px 14px; font-weight:600; }
      .live { color:var(--green); } .dot { display:inline-block; width:8px; height:8px; border-radius:50%; background:var(--green); margin-right:6px; }
      main { display:grid; grid-template-columns:1fr 380px; gap:18px; padding:18px 24px; }
      @media (max-width:900px){ main{ grid-template-columns:1fr } }
      .map { position:relative; min-height:620px; border-radius:6px; overflow:hidden; border:1px solid var(--line);
        background:
          radial-gradient(circle at 42% 52%, rgba(255,220,0,.55), transparent 28%),
          radial-gradient(circle at 45% 50%, rgba(60,220,90,.55), transparent 50%),
          repeating-linear-gradient(35deg, #2b3338 0 2px, #3a4348 2px 60px),
          #3a4348; }
      .map h2 { position:absolute; left:30px; top:26px; font-size:17px; }
      .map h2 span { display:block; margin-top:4px; color:#8fe6c0; }
      .panel { background:var(--panel); border:1px solid var(--line); border-radius:8px; }
      .tabs { position:absolute; left:30px; top:96px; width:156px; padding:6px; }
      .tabs div { padding:11px 14px; border-radius:6px; font-size:12px; font-weight:600; color:#aeb9c4; }
      .tabs .on { background:var(--green); color:#04261a; }
      .src { position:absolute; left:30px; top:246px; width:256px; padding:14px 16px; }
      .src .row { display:flex; align-items:center; gap:12px; padding:10px 0; border-top:1px solid var(--line); }
      .src .row:first-of-type { border:0 }
      .src i { width:7px; height:7px; border-radius:50%; }
      .src b { display:block; font-size:13px; } .src small { color:var(--mut); font:10px ui-monospace,monospace; }
      .tog { margin-left:auto; width:34px; height:18px; border-radius:9px; background:#1f6b52; position:relative; }
      .tog:after { content:''; position:absolute; right:3px; top:3px; width:12px; height:12px; border-radius:50%; background:var(--green); }
      .lbl { position:absolute; background:rgba(8,12,16,.92); padding:8px 11px; border-left:2px solid; font:600 11px ui-monospace,monospace; }
      .lbl b { display:block; color:#fff; font-family:system-ui; margin-bottom:3px; }
      .legend { position:absolute; right:22px; top:26px; padding:12px 14px; width:130px; }
      .legend div { height:5px; border-radius:3px; margin-top:8px; background:linear-gradient(90deg,#2a6bff,#2de39a,#ffe000,#ff6a1a); }
      svg.net { position:absolute; inset:0; width:100%; height:100%; pointer-events:none; }
      aside .panel { padding:20px 24px; margin-bottom:14px; }
      .big { font-size:34px; font-weight:700; } .big small { font-size:12px; color:var(--mut); }
      .chart { display:flex; align-items:flex-end; gap:4px; height:120px; margin-top:20px; }
      .chart span { flex:1; background:var(--orange); border-radius:1px 1px 0 0; }
      .chart span.f { background:repeating-linear-gradient(45deg,#7a3515 0 2px,#1a0d06 2px 4px); }
      .leg div { margin-bottom:12px; font-size:12px; color:#aab5c0; } .leg b { display:block; color:#fff; }
    </style>
  </head>
  <body>
    <header>
      <div class="logo">TG</div>
      <div><h1>THERMALGRID</h1><div class="mono">District Operations / Dordrecht</div></div>
      <div class="sp"></div>
      <div class="mono"><span class="dot"></span>System live <span class="live">MW</span> &nbsp; <?= $now->format('H:i:s') ?> CET</div>
    </header>

    <main>
      <section class="map">
      <img src="{{asset('images/kaart.png')}}" alt="kaart">
      </section>
      <aside>
        <div class="panel">
          <div class="mono">Generated heat</div>
          <div class="chart">
            <?php foreach ($bars as $i => $h) echo '<span class="' . ($i > 14 ? 'f' : '') . '" style="height:' . $h . '%"></span>'; ?>
          </div>
          <div class="mono" style="display:flex; justify-content:space-between; margin-top:8px"><span>06:00</span><span>12:00</span><span>18:00</span><span>Now</span></div>
        </div>
      </aside>
    </main>
  </body>
</html>
