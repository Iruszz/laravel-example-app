<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\UpdateAgentRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function update(UpdateAgentRequest $request, Ticket $ticket)
    {
        if ($request->user()->cannot('assignAgent', $ticket)) {
            return ApiResponse::forbidden(
                'Only admins are allowed to assign agents to tickets.', 
                'AGENT_ASSIGNMENT_FORBIDDEN'
            );
        }

        $ticket->update($request->validated());
        
        $tickets = Ticket::with(['user', 'status', 'category'])->get();
        return response()->json($tickets);
    }
}
