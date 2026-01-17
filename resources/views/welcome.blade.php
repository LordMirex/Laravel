<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task Manager | Influencer Engine</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        </style>
    </head>
    <body class="p-6 md:p-12">
        <div class="max-w-4xl mx-auto">
            <header class="flex justify-between items-center mb-12">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Task Board</h1>
                    <p class="text-slate-500 mt-1">Manage your creator workflow</p>
                </div>
                <div class="flex gap-4">
                     @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">Log in</a>
                        @endauth
                    @endif
                </div>
            </header>

            <section class="mb-10">
                <form action="/tasks" method="POST" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="title" placeholder="What needs to be done?" 
                                class="w-full px-4 py-3 rounded-2xl border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" required>
                        </div>
                        <div class="flex-1">
                            <input type="text" name="description" placeholder="Short description (optional)" 
                                class="w-full px-4 py-3 rounded-2xl border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-2xl font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                            Add Task
                        </button>
                    </div>
                </form>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $tasks = \App\Models\Task::latest()->get();
                @endphp

                @foreach($tasks as $task)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-md transition-all group relative">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4">
                                <form action="/tasks/{{ $task->id }}/toggle" method="POST" class="mt-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="checkbox" onchange="this.form.submit()" 
                                        {{ $task->completed ? 'checked' : '' }}
                                        class="w-5 h-5 rounded-full border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                </form>
                                <div>
                                    <h3 class="text-lg font-semibold {{ $task->completed ? 'line-through text-slate-400' : 'text-slate-900' }}">
                                        {{ $task->title }}
                                    </h3>
                                    @if($task->description)
                                        <p class="text-sm text-slate-500 mt-1 {{ $task->completed ? 'line-through' : '' }}">
                                            {{ $task->description }}
                                        </p>
                                    @endif
                                    <div class="flex gap-2 mt-4">
                                        <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded-lg {{ $task->completed ? 'bg-slate-100 text-slate-500' : 'bg-blue-50 text-blue-600' }}">
                                            {{ $task->completed ? 'Completed' : 'In Progress' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <form action="/tasks/{{ $task->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                @if($tasks->isEmpty())
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900">No tasks yet</h3>
                        <p class="text-slate-500">Get started by creating your first workflow task.</p>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
