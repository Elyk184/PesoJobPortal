{{-- filepath: c:\xampp\htdocs\PESO-LINK\resources\views\dashboard\jobseeker.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Dashboard</title>
</head>
<body>
    <h1>Jobseeker Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name ?? 'Jobseeker' }}.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
