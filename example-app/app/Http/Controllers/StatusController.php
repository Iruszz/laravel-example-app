<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(StoreStatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        $statuss = Status::with(['user', 'status', 'category'])->get();
        return response()->json($statuss);
    }
}
