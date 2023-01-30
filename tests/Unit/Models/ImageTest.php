<?php

namespace Models;

use App\Models\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function test_if_fillables_are_correct()
    {
        $image = new Image();
        $this->assertEquals([
            'name',
            'path',
            'created_at',
            'updated_at',
        ], $image->getFillable());
    }

    public function test_if_table_name_is_correct()
    {
        $image = new Image();
        $this->assertEquals('images', $image->getTable());
    }
}
