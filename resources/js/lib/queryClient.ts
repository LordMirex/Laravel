import { QueryClient } from '@tanstack/react-query';

export async function apiRequest(method, url, data) {
    const res = await fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        },
        body: data ? JSON.stringify(data) : undefined,
    });

    if (!res.ok) {
        throw new Error(res.statusText);
    }

    return res;
}

export const queryClient = new QueryClient();
