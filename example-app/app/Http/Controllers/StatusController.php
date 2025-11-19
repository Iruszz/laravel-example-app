<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $this->authorize('update', $status);

        $status->name = 'solved';
        // TODO: update en save is dubbel op
        $status->save();

        $status->update($request->validated());

        $status->load(['user', 'status', 'category']);

        return response()->json($status);
    }
}
