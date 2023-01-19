<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.6/dist/vue-multiselect.min.css">
    <!-- Scripts -->
    @routes
    @vite('resources/ts/app.ts')
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>

<style>
    html,
    body {
        padding: 0;
        margin: 0;
    }
</style>