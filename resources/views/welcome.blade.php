<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                    <h1 class="mb-1 font-medium">Laravel Task Manager</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Welcome back to your simple task manager. Your tasks are stored in the database.</p>
                    
                    <div class="mt-6">
                        @php
                            $tasks = \App\Models\Task::latest()->get();
                        @endphp

                        <form action="/tasks" method="POST" class="flex gap-2 mb-6">
                            @csrf
                            <input type="text" name="title" placeholder="New task..." class="flex-1 px-3 py-2 border rounded-md dark:bg-black dark:border-white/20" required>
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded-md dark:bg-white dark:text-black">Add</button>
                        </form>

                        <div class="space-y-2">
                            @foreach($tasks as $task)
                                <div class="flex items-center justify-between p-3 border rounded-md dark:border-white/10">
                                    <div class="flex items-center gap-3">
                                        <form action="/tasks/{{ $task->id }}/toggle" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                        </form>
                                        <span class="{{ $task->completed ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</span>
                                    </div>
                                    <form action="/tasks/{{ $task->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-xs">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
