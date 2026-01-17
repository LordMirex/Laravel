<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Preflight</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-lg w-full">
        <h1 class="text-2xl font-bold mb-4">Server Requirements</h1>
        <ul class="space-y-2 mb-6">
            @foreach($checks as $check => $status)
                <li class="flex items-center justify-between p-2 border-b">
                    <span class="capitalize">{{ str_replace('_', ' ', $check) }}</span>
                    @if($status)
                        <span class="text-green-600 font-bold">PASS</span>
                    @else
                        <span class="text-red-600 font-bold">FAIL</span>
                    @endif
                </li>
            @endforeach
        </ul>
        @if(collect($checks)->every(fn($status) => $status))
            <a href="{{ route('installer.database') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block w-full text-center">Continue</a>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                Please fix the requirements above to continue.
            </div>
            <button onclick="window.location.reload()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 inline-block w-full text-center">Retry</button>
        @endif
    </div>
</body>
</html>
