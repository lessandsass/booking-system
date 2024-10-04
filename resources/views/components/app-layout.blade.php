<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookings</title>

    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])

</head>
<body>

    <div class="max-w-4xl mx-auto my-12 px-6">
        {{ $slot }}
    </div>

</body>
</html>
