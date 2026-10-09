<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <a href="/Upload" >Go to Upload <a>
@if(session('success'))
    <div style="padding: 15px; background-color: #d4edda; color: #155724; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

    
</body>
</html>