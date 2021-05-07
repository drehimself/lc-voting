<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function idea_comments_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $commentOne = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSeeLivewire('idea-comments');
    }

    /** @test */
    public function idea_comment_livewire_component_renders()
    {
        $idea = Idea::factory()->create();

        $commentOne = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSeeLivewire('idea-comment');
    }

    /** @test */
    public function no_comments_shows_appropriate_message()
    {
        $idea = Idea::factory()->create();

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('No comments yet');
    }

    /** @test */
    public function list_of_comments_shows_on_idea_page()
    {
        $idea = Idea::factory()->create();

        $commentOne = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $commentTwo = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my second comment',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSeeInOrder(['This is my first comment', 'This is my second comment']);
        $response->assertSee('2 comments');
    }

    /** @test */
    public function comments_count_shows_correctly_on_index_page()
    {
        $idea = Idea::factory()->create();

        $commentOne = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $commentTwo = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my second comment',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSee('2 comments');
    }

    /** @test */
    public function op_badge_shows_if_author_of_idea_comments_on_idea()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $commentOne = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $commentTwo = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my second comment',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee('OP');
    }

    /** @test */
    public function comments_pagination_works()
    {
        $idea = Idea::factory()->create();

        $commentOne = Comment::factory()->create([
            'idea_id' => $idea
        ]);

        Comment::factory($commentOne->getPerPage())->create([
            'idea_id' => $idea->id,
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSee($commentOne->body);
        $response->assertDontSee(Comment::find(Comment::count())->body);

        $response = $this->get(route('idea.show', [
            'idea' => $idea,
            'page' => 2,
        ]));

        $response->assertDontSee($commentOne->body);
        $response->assertSee(Comment::find(Comment::count())->body);
    }
}
