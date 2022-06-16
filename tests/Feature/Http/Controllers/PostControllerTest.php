<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   function TOPページで、ブログ一覧が表示される()
   {
        $post1 = Post::factory()->hasComments(3)->create(['title' => 'ブログのタイトル1']);
        $post2 = Post::factory()->hasComments(5)->create(['title' => 'ブログのタイトル2']);
        Post::factory()->hasComments(1)->create();

        $this->get('/')
            ->assertOk()
            ->assertSee('ブログのタイトル1')
            ->assertSee('ブログのタイトル2')
            ->assertSee($post1->user->name)
            ->assertSee($post2->user->name)
            ->assertSeeInOrder([
                '(5件のコメント)',
                '(3件のコメント)',
                '(1件のコメント)'
            ]);
   }

      /** @test */
    function ブログの一覧で、非公開のブログは表示されない()
    {
        $post1 = Post::factory()->closed()->create([
            'title' => 'これは非公開のブログです',
        ]);

        $post2 = Post::factory()->create([
            'title' => 'これは公開済みのブログです',
        ]);

        $this->get('/')
            ->assertDontSee('これは非公開のブログです')
            ->assertSee('これは公開済みのブログです');
    }

        /** @test */
        function 詳細画面でクリスマスの日は、メリークリスマス！と表示される()
        {
            $post = Post::factory()->create();

            Carbon::setTestNow('2020-12-24');

            $this->get('posts/' . $post->id)
                ->assertOk()
                ->assertDontSee('メリークリスマス！');

            Carbon::setTestNow('2020-12-25');

            $this->get('posts/' . $post->id)
                ->assertOk()
                ->assertSee('メリークリスマス！');
        }
}
