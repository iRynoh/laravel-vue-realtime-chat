<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('room.{roomId}', function (User $user, $roomId) {
    // Here we can define some guards in the future
    return true;
});
