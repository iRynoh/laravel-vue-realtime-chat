<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->room = Room::factory()->create([
        'title' => 'Test Room',
        'slug' => 'test-room'
    ]);
});

test('guests cannot view rooms', function () {
    $response = $this->get(route('room.show', [
        'room' => $this->room
    ]));

    $response->assertRedirect(route('login'));
});

test('users can view rooms', function () {
    $response = actingAs($this->user)
        ->get(route('room.show', [
            'room' => $this->room
        ]));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Room')
        ->has('room', fn (Assert $room) => $room
            ->where('id', $this->room->id)
            ->where('title', $this->room->title)
            ->where('slug', $this->room->slug)
        )
    );
});

test('404 is returned when room does not exist', function () {
    $response = actingAs($this->user)
        ->get(route('room.show', [
            'room' => 'non-existent-room'
        ]));

    $response->assertNotFound();
});
