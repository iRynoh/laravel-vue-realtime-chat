<?php

use App\Models\Room;
use App\Models\User;
use App\Models\Message;
use Illuminate\Testing\Fluent\AssertableJson;

test('guest cannot access messages', function () {
    $room = Room::factory()->create();

    $this->get(route('room.show.messages', $room))
        ->assertRedirect(route('login'));
});

test('user can view messages from a room', function () {
    // Arrange
    $user = User::factory()->create();
    $room = Room::factory()->create();
    $messages = Message::factory()->count(3)->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'body' => 'This is a message body'
    ]);

    // Act
    $response = $this->actingAs($user)
        ->get(route('room.show.messages', $room));

    // Assert
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'body',
                    'created_at',
                    'user' => [
                        'id',
                        'name'
                    ]
                ]
            ],
            'links',
            'meta'
        ]);
});

test('messages are paginated', function () {
    // Arrange
    $user = User::factory()->create();
    $room = Room::factory()->create();
    Message::factory()->count(25)->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'body' => 'This is a message body'
    ]);

    // Act
    $response = $this->actingAs($user)
        ->get(route('room.show.messages', $room));

    // Assert
    $response->assertOk()
        ->assertJsonCount(20, 'data')  // Default pagination is 20
        ->assertJsonStructure([
            'data',
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);
});

test('messages are ordered by latest first', function () {
    // Arrange
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $oldMessage = Message::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'body' => 'Old message',
        'created_at' => now()->subDays(2)
    ]);

    $newMessage = Message::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'body' => 'New message',
        'created_at' => now()
    ]);

    // Act
    $response = $this->actingAs($user)
        ->get(route('room.show.messages', $room));

    // Assert
    $response->assertOk()
        ->assertJsonStructure([
            'data',
            'links',
            'meta'
        ])
        ->assertJson(fn (AssertableJson $json) =>
        $json->has('data', 2)
            ->where('data.0.body', $newMessage->body)
            ->where('data.1.body', $oldMessage->body)
            ->etc()
        );
});

test('messages include user relationship', function () {
    // Arrange
    $user = User::factory()->create(['name' => 'John Doe']);
    $room = Room::factory()->create();
    Message::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'body' => 'New message',
    ]);

    // Act
    $response = $this->actingAs($user)
        ->get(route('room.show.messages', $room));

    // Assert
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'user' => [
                        'id',
                        'name'
                    ]
                ]
            ],
            'links',
            'meta'
        ])
        ->assertJson(fn (AssertableJson $json) =>
        $json->has('data', 1)
            ->has('data.0.user', fn ($json) =>
            $json->where('id', $user->id)
                ->where('name', 'John Doe')
                ->etc()
            )
            ->etc()
        );
});
