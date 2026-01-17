<?php

namespace App\Repositories;

use App\Models\Block;

class BlockRepository
{
    public function getAllEnabled()
    {
        return Block::where('enabled', true)->orderBy('order_index')->get();
    }

    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            Block::where('id', $id)->update(['order_index' => $index]);
        }
    }
}
