<?php

function generate_all_orders($items, $step = 0)
{
    if (count($items) === 1) {
        return [$items];
    }
    $paths = [];
    foreach ($items as $item) {
        $index = array_search($item, $items);
        $newItems = $items;
        array_splice($newItems, $index, 1);
        $nextPaths = generate_all_orders($newItems, $step + 1);
        foreach ($nextPaths as $k => $path)
        {
            array_unshift($nextPaths[$k], $item);
            $paths[] = $nextPaths[$k];
        }
    }
    return $paths;
}
