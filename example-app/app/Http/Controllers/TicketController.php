<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\User;

class TicketController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::unauthorized('You must be logged in.');
        }

        $tickets = Ticket::with(['user', 'status', 'category', 'agent'])
                        ->when($user && !$user->is_admin, function($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        return response()->json($tickets);
    }

    public function show(Request $request, Ticket $ticket)
    {   
        $user = Auth::user();

        if ($request->user()->cannot('view', $ticket)) {
            return ApiResponse::forbidden('You cannot view this ticket.', 'TICKET_FORBIDDEN');
        }

        $ticket->load(['user', 'category', 'status']);

        return response()->json($ticket);
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['status_id'] = 1;

        $ticket = Ticket::create($data);

    
        \App\Models\Comment::factory()->count(3)->create([
            'ticket_id' => $ticket->id,
        ]);

        return response()->json($ticket, 201);
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        $tickets = Ticket::with(['user', 'status', 'category'])->get();
        return response()->json($tickets);
    }

    public function updateStatus(UpdateStatusRequest $request, Ticket $ticket)
    {
        // $this->authorize('update', $ticket);

        $ticket->update($request->validated());

        $ticket->load(['user', 'status', 'category']);
        return response()->json($ticket);
    }

    public function updateAgent(UpdateAgentRequest $request, Ticket $ticket)
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

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
