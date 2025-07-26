<?php
use App\Models\User;
use App\Models\Admin;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

// ✅ Admin can update any post and assign it to another user
it('allows admin to update any post and assign to any user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $newUser = User::factory()->create();

    $response = $this->actingAs($admin)->putJson("/api/posts/{$post->id}", [
        'title' => 'Updated Title by Admin',
        'content' => 'New content',
        'user_id' => $newUser->id,
        'status' => 'draft',
    ]);

    $response->assertOk();
    expect($post->fresh()->title)->toBe('Updated Title by Admin');
    expect($post->fresh()->user_id)->toBe($newUser->id);
});

// ❌ Regular user cannot update someone else’s post
it('prevents regular user from updating others post', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($user)->putJson("/api/posts/{$post->id}", [
        'title' => 'Hack attempt',
        'content' => 'Hacked content',
        'user_id' => $user->id,
        'status' => 'draft',
    ]);

    $response->assertStatus(422); // Fails validation due to ownership
    expect($post->fresh()->title)->not->toBe('Hack attempt');
});

// ❌ Regular user cannot assign post to another user
it('prevents regular user from changing post ownership', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $otherUser = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/posts/{$post->id}", [
        'title' => 'Valid update',
        'content' => 'Content stays',
        'user_id' => $otherUser->id,
        'status' => 'published',
    ]);

    $response->assertStatus(422); // Validation should fail
    expect($post->fresh()->user_id)->toBe($user->id);
});

// ✅ Regular user can update their own post
it('allows regular user to update their own post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->putJson("/api/posts/{$post->id}", [
        'title' => 'User updates title',
        'content' => 'Updated content',
        'user_id' => $user->id,
        'status' => 'draft',
    ]);

    $response->assertOk();
    expect($post->fresh()->title)->toBe('User updates title');
});
