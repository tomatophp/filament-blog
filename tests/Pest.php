<?php

use TomatoPHP\FilamentAccounts\Models\Account;
use TomatoPHP\FilamentBlog\Tests\Database\Factories\AccountFactory;
use TomatoPHP\FilamentBlog\Tests\TestCase;
use TomatoPHP\FilamentCms\Models\Post;

uses(TestCase::class)->in(__DIR__);

/**
 * A published CMS post of the given type.
 *
 * @param  array<string, mixed>  $attributes
 */
function blogPost(string $type = 'post', string $slug = 'hello-world', array $attributes = []): Post
{
    return Post::query()->create(array_merge([
        'type' => $type,
        'slug' => $slug,
        'title' => ['en' => 'Title of '.$slug, 'ar' => 'عنوان '.$slug],
        'short_description' => ['en' => 'Short description of '.$slug],
        'keywords' => ['en' => 'blog'],
        'body' => ['en' => 'Body of '.$slug],
        'is_published' => true,
        'published_at' => now(),
    ], $attributes));
}

function blogAccount(): Account
{
    return AccountFactory::new()->create();
}
