<?php

use App\Events\MessageCreated;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->room = Room::factory()->create();
});

test('guests cannot create messages', function () {
    $response = $this->postJson(route('room.show.messages.store', [
        'room' => $this->room
    ]), [
        'body' => 'Test message'
    ]);

    $response->assertUnauthorized();
});

test('users can create messages', function () {
    Event::fake();

    $response = actingAs($this->user)
        ->postJson(route('room.show.messages.store', [
            'room' => $this->room
        ]), [
            'body' => 'Test message'
        ]);

    $response->assertCreated()
        ->assertJson([
            'id' => 1,
            'body' => 'Test message',
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar()
            ],
            'created_at' => $response->json('created_at')
        ]);

    $this->assertDatabaseHas('messages', [
        'body' => 'Test message',
        'user_id' => $this->user->id,
        'room_id' => $this->room->id,
    ]);

    Event::assertDispatched(MessageCreated::class);
});

test('message body is required', function () {
    $response = actingAs($this->user)
        ->postJson(route('room.show.messages.store', [
            'room' => $this->room
        ]), [
            'body' => ''
        ]);

    $response->assertJsonValidationErrors(['body']);
});

test('message body must be a string', function () {
    $response = actingAs($this->user)
        ->postJson(route('room.show.messages.store', [
            'room' => $this->room
        ]), [
            'body' => ['not a string']
        ]);

    $response->assertJsonValidationErrors(['body']);
});
