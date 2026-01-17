import React, { useState } from 'react';
import { useQuery, useMutation } from '@tanstack/react-query';
import { apiRequest, queryClient } from '../lib/queryClient';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Checkbox } from '@/components/ui/checkbox';
import { Trash2, Plus } from 'lucide-react';
import { useToast } from '@/hooks/use-toast';

export default function TaskManager() {
    const { toast } = useToast();
    const [title, setTitle] = useState('');

    const { data: tasks, isLoading } = useQuery({
        queryKey: ['/api/tasks'],
    });

    const createMutation = useMutation({
        mutationFn: async (newTask) => {
            const res = await apiRequest('POST', '/api/tasks', newTask);
            return res.json();
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['/api/tasks'] });
            setTitle('');
            toast({ title: 'Task created successfully' });
        },
    });

    const toggleMutation = useMutation({
        mutationFn: async ({ id, completed }) => {
            const res = await apiRequest('PATCH', `/api/tasks/${id}`, { completed });
            return res.json();
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['/api/tasks'] });
        },
    });

    const deleteMutation = useMutation({
        mutationFn: async (id) => {
            await apiRequest('DELETE', `/api/tasks/${id}`);
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['/api/tasks'] });
            toast({ title: 'Task deleted' });
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!title.trim()) return;
        createMutation.mutate({ title });
    };

    if (isLoading) return <div>Loading tasks...</div>;

    return (
        <div className="p-6 max-w-2xl mx-auto space-y-6">
            <Card>
                <CardHeader>
                    <CardTitle>Task Manager</CardTitle>
                </CardHeader>
                <CardContent>
                    <form onSubmit={handleSubmit} className="flex gap-2">
                        <Input
                            placeholder="Add a new task..."
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            data-testid="input-task-title"
                        />
                        <Button type="submit" disabled={createMutation.isPending} data-testid="button-add-task">
                            <Plus className="w-4 h-4 mr-2" />
                            Add
                        </Button>
                    </form>
                </CardContent>
            </Card>

            <div className="space-y-3">
                {tasks?.map((task) => (
                    <Card key={task.id} className="hover-elevate">
                        <CardContent className="flex items-center justify-between p-4">
                            <div className="flex items-center gap-3">
                                <Checkbox
                                    checked={!!task.completed}
                                    onCheckedChange={(checked) => 
                                        toggleMutation.mutate({ id: task.id, completed: checked })
                                    }
                                    data-testid={`checkbox-task-${task.id}`}
                                />
                                <span className={task.completed ? 'line-through text-muted-foreground' : ''}>
                                    {task.title}
                                </span>
                            </div>
                            <Button
                                variant="ghost"
                                size="icon"
                                onClick={() => deleteMutation.mutate(task.id)}
                                className="text-destructive"
                                data-testid={`button-delete-task-${task.id}`}
                            >
                                <Trash2 className="w-4 h-4" />
                            </Button>
                        </CardContent>
                    </Card>
                ))}
            </div>
        </div>
    );
}
