<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Migrations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-lg w-full">
        <h1 class="text-2xl font-bold mb-4">Run Migrations</h1>
        <p class="mb-6 text-gray-600">The database is connected. Now we need to create the tables.</p>
        
        <div id="status" class="hidden p-3 rounded text-sm mb-4"></div>
        <pre id="output" class="hidden p-3 bg-black text-green-400 text-xs rounded mb-4 max-h-48 overflow-auto"></pre>

        <button id="run-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block w-full text-center">Run Migrations</button>
    </div>

    <script>
        document.getElementById('run-btn').addEventListener('click', async () => {
            const btn = document.getElementById('run-btn');
            const status = document.getElementById('status');
            const output = document.getElementById('output');
            
            btn.disabled = true;
            btn.innerText = 'Running Migrations...';
            status.classList.add('hidden');
            output.classList.add('hidden');

            try {
                const res = await fetch('{{ route('installer.migrate.run') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await res.json();
                
                if (data.success) {
                    status.innerText = 'Success! Tables created.';
                    status.className = 'p-3 rounded text-sm bg-green-100 text-green-700 block mb-4';
                    output.innerText = data.output;
                    output.classList.remove('hidden');
                    btn.innerText = 'Continue to Admin Setup';
                    btn.disabled = false;
                    btn.onclick = () => alert('Next: Admin Setup');
                } else {
                    throw new Error(data.message || 'Migrations failed');
                }
            } catch (err) {
                status.innerText = err.message;
                status.className = 'p-3 rounded text-sm bg-red-100 text-red-700 block mb-4';
                btn.disabled = false;
                btn.innerText = 'Retry Migrations';
            }
        });
    </script>
</body>
</html>
