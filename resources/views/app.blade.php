<!DOCTYPE html>
<html lang="pt-BR" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#09090B">

        <title inertia>{{ config('blog.name', 'CyberSec Blog') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />

        @routes
        @vite(['resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-cyber-bg text-cyber-text">
        @inertia
    </body>
</html>
