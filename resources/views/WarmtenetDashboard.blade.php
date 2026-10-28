<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     @vite(['resources/css/Dashboard.css'])
</head>
<body>
@if(session('success'))
<script>
        alert("CSV file uploaded successfully!");
</script>
@endif



<header class="navbar">
  <img src="images/logo.png" alt="Logo" class="logo-flex">
    <nav class="nav-links">
        <a href="/Upload">Upload</a>
    </nav>
</header>

  
</body>
</html>

