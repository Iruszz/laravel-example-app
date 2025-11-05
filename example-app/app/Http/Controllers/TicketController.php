<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\User;

class TicketController extends Controller
{

    protected function loadRelations(Ticket $ticket)
    {
        return $ticket->load(['user', 'status', 'category', 'agent']);
    }


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
        
        return TicketResource::collection($tickets);
    }

    public function show(Request $request, Ticket $ticket)
    {   
        $user = Auth::user();

        if ($request->user()->cannot('view', $ticket)) {
            return ApiResponse::forbidden('You cannot view this ticket.', 'TICKET_FORBIDDEN');
        }

        return new TicketResource($this->loadRelations($ticket));
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

        return (new TicketResource($ticket))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $ticket->update($request->validated());

        $ticket->load(['user', 'status', 'category', 'agent']);
        return new TicketResource($ticket);
    }

    public function updateStatus(UpdateStatusRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->status_id = $request->validated()['status_id'];
        $ticket->save();

        return new TicketResource($this->loadRelations($ticket));
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
        
        return new TicketResource($this->loadRelations($ticket));
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();

        return response()->noContent();
    }
}
