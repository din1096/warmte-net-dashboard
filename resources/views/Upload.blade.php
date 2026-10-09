<!-- resources/views/Upload.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
</head>
<body>
    <h2>Upload CSV File to Warmtenet Database</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="csv_file">Choose CSV File:</label>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
        <br><br>
        <button type="submit">Upload and Import</button>
    </form>
</body>
</html>
