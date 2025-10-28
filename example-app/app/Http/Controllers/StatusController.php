<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(Request $request, Status $status)
    {
        $this->authorize('update', $status);

        $status->name = 'solved';
        $status->save();

        $status->load(['user', 'status', 'category']);

        return response()->json($status);
    }
}
