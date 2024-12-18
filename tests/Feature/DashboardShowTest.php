<?php

use App\Models\Room;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guest cannot access dashboard', function () {
    // Act & Assert
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});

test('dashboard page can be rendered with rooms data', function () {
    // Arrange
    $user = User::factory()->create();

    $rooms = Room::factory()->count(3)->sequence(
        ['title' => 'Test Room 1', 'slug' => 'test-room-1'],
        ['title' => 'Test Room 2', 'slug' => 'test-room-2'],
        ['title' => 'Test Room 3', 'slug' => 'test-room-3']
    )->create();

    // Act
    $response = $this->actingAs($user)
        ->get(route('dashboard'));

    // Assert
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Dashboard')
        ->has('rooms', 3)
        ->where('rooms.0.title', $rooms[0]->title)
        ->where('rooms.0.slug', $rooms[0]->slug)
        ->where('rooms.1.title', $rooms[1]->title)
        ->where('rooms.1.slug', $rooms[1]->slug)
        ->where('rooms.2.title', $rooms[2]->title)
        ->where('rooms.2.slug', $rooms[2]->slug)
    );
});

test('rooms are transformed using rooms resource', function () {
    // Arrange
    $user = User::factory()->create();
    $room = Room::factory()->create([
        'title' => 'Test Room Title',
        'slug' => 'test-room-slug'
    ]);

    // Act
    $response = $this->actingAs($user)
        ->get(route('dashboard'));

    // Assert
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Dashboard')
        ->has('rooms.0', fn (Assert $page) => $page
            ->where('id', $room->id)
            ->where('title', $room->title)
            ->where('slug', $room->slug)
        )
    );
});
