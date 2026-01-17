<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4">Welcome to Installer</h1>
        <p class="mb-6">This wizard will guide you through the setup of your creator application.</p>
        <a href="{{ route('installer.preflight') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block w-full text-center">Start Setup</a>
    </div>
</body>
</html>
