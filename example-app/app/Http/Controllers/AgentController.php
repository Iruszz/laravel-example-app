<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAgentRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function update(UpdateAgentRequest $request, Ticket $ticket)
    {
        $this->authorize('assignAgent', $ticket);

        $ticket->update($request->validated());

        if ($request->user()->cannot('update', $ticket)) {
            return response()->json([
                'message' => 'Only admins are allowed to assign agents to tickets.',
                'code' => 'AGENT_ASSIGNMENT_FORBIDDEN',
            ], 403);
        }

        $tickets = Ticket::with(['user', 'status', 'category'])->get();
        return response()->json($tickets);
    }
}
