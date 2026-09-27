<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class TableRow implements \JsonSerializable
{
    /** @var list<mixed> */
    private array $children = [];

    public static function make(mixed ...$children): self
    {
        $row = new self();
        $row->children = self::listOf($children);

        return $row;
    }

    public function jsonSerialize(): array
    {
        return ['children' => $this->children];
    }

    /**
     * @param  list<mixed>  $items
     * @return list<mixed>
     */
    private static function listOf(array $items): array
    {
        if (count($items) === 1 && is_array($items[0]) && array_is_list($items[0])) {
            return $items[0];
        }

        return $items;
    }
}
