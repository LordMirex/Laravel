<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Database Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-lg w-full">
        <h1 class="text-2xl font-bold mb-4">Database Configuration</h1>
        <p class="mb-6 text-gray-600">Enter your MySQL database credentials below.</p>
        
        <form id="db-form" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Host</label>
                <input type="text" name="host" value="shuttle.proxy.rlwy.net" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Port</label>
                <input type="number" name="port" value="17743" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Database Name</label>
                <input type="text" name="database" value="railway" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="root" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" value="SdaWWXDTppnLDpiELvFpcZzURHctSPLH" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
            
            <div id="status" class="hidden p-3 rounded text-sm"></div>

            <button type="submit" id="submit-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block w-full text-center">Test & Continue</button>
        </form>
    </div>

    <script>
        document.getElementById('db-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('submit-btn');
            const status = document.getElementById('status');
            const formData = new FormData(e.target);
            
            btn.disabled = true;
            btn.innerText = 'Testing Connection...';
            status.classList.add('hidden');

            try {
                const res = await fetch('{{ route('installer.database.test') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await res.json();
                
                if (data.success) {
                    status.innerText = 'Success! Redirecting...';
                    status.className = 'p-3 rounded text-sm bg-green-100 text-green-700 block';
                    setTimeout(() => {
                        window.location.href = '{{ route('installer.migrate') }}';
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Connection failed');
                }
            } catch (err) {
                status.innerText = err.message;
                status.className = 'p-3 rounded text-sm bg-red-100 text-red-700 block';
                btn.disabled = false;
                btn.innerText = 'Test & Continue';
            }
        });
    </script>
</body>
</html>
