<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomsResource;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('Dashboard', [
            'rooms' => RoomsResource::collection(Room::all(['id', 'title', 'slug'])),
        ]);
    }
}
