<?php

namespace Models;

use App\Models\Blog;
use PHPUnit\Framework\TestCase;

class BlogTest extends TestCase
{
    public function test_if_fillables_are_correct()
    {
        $blog = new Blog();
        $this->assertEquals([
            'title',
            'content',
            'slug',
            'user_id',
            'image_id',
            'created_at',
            'updated_at',
        ], $blog->getFillable());
    }

    public function test_if_table_name_is_correct()
    {
        $blog = new Blog();
        $this->assertEquals('blogs', $blog->getTable());
    }
}
