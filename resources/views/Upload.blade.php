<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
    @vite(['resources/css/Upload.css'])
</head>
    <!-- <header class="navbar">
        <img src="images/logo.png" alt="Logo" class="logo-flex">
            <nav class="nav-links">
                <a href="/">Upload</a>
            </nav>
    </header> -->
<body>
    <div class="upload-container">
        <h2>Upload CSV to Database</h2>

        @if(session('success'))
            <p class="msg-success">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="msg-error">{{ session('error') }}</p>
        @endif

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
</body>
</html>
