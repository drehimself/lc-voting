<?php

namespace Tests\Feature\Comments;

use App\Http\Livewire\AddComment;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AddCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_comment_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSeeLivewire('add-comment');
    }

    /** @test */
    public function add_comment_form_renders_when_user_is_logged_in()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $response = $this->actingAs($user)->get(route('idea.show', $idea));

        $response->assertSee('Share your thoughts');
    }

    /** @test */
    public function add_comment_form_does_not_render_when_user_is_logged_out()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('Please login or create an account to post a comment');
    }

    /** @test */
    public function add_comment_form_validation_works()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(AddComment::class, [
                'idea' => $idea,
            ])
            ->set('comment', '')
            ->call('addComment')
            ->assertHasErrors(['comment'])
            ->set('comment', 'ab')
            ->call('addComment')
            ->assertHasErrors(['comment']);
    }

    /** @test */
    public function add_comment_form__works()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(AddComment::class, [
                'idea' => $idea,
            ])
            ->set('comment', 'This is my first comment')
            ->call('addComment')
            ->assertEmitted('commentWasAdded');

        $this->assertEquals(1, Comment::count());
        $this->assertEquals('This is my first comment', $idea->comments->first()->body);
    }
}
