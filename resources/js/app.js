import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './lib/queryClient';
import TaskManager from './components/TaskManager';
import { Toaster } from './components/ui/toaster';

const container = document.getElementById('app');
if (container) {
    const root = createRoot(container);
    root.render(
        <QueryClientProvider client={queryClient}>
            <TaskManager />
            <Toaster />
        </QueryClientProvider>
    );
}

