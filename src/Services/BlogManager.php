<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;

class BlogManager
{
    public static function upsert_blog(iterable $data, iterable $resource = [], Blog $blog = null ):bool
    {
        $blog = $blog ?? new Blog();
        foreach ($data as $key => $val){
            $blog->$key = $val;
        }
        if (empty($blog->slug)){
            $blog->slug = self::create_unique_slug($blog->title);
        }
        foreach ($resource as $name => $value){
           if ($value instanceof Model && method_exists($blog, $name)){
              $blog->$name->save($value);
           }
        }

        return $blog->save();
    }

    public static function create_unique_slug(string $text, string $divider = '-'):string
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        $text = $text ?? 'n-a';

        $existing_slugs = Blog::where('slug', 'like', $text . '%')->count();

        if ($existing_slugs > 0){
            $text .= '-' . $existing_slugs + 1;
        }

        return $text;
    }

    public static function delete_blog(int $blog_id):bool
    {
        $blog = Blog::where('id', $blog_id)->where('user_id', AuthManager::get_authenticated_user_id())->first();
        if ($blog){
            return $blog->delete();
        }
        return false;
    }

}