<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::orderBy('order_index')->get();
        return view('admin.blocks.index', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'content' => 'required|json',
        ]);

        $maxOrder = Block::max('order_index') ?? -1;

        Block::create([
            'type' => $validated['type'],
            'content' => json_decode($validated['content'], true),
            'order_index' => $maxOrder + 1,
            'enabled' => true,
        ]);

        return back()->with('success', 'Block added successfully');
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'content' => 'sometimes|json',
            'enabled' => 'sometimes|boolean',
            'order_index' => 'sometimes|integer',
        ]);

        if (isset($validated['content'])) {
            $validated['content'] = json_decode($validated['content'], true);
        }

        $block->update($validated);

        return back()->with('success', 'Block updated successfully');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|exists:blocks,id',
            'blocks.*.order_index' => 'required|integer',
        ]);

        foreach ($request->blocks as $item) {
            Block::where('id', $item['id'])->update(['order_index' => $item['order_index']]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Block $block)
    {
        $block->delete();
        return back()->with('success', 'Block deleted successfully');
    }
}
