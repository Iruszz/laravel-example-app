<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Models\User;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
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
            return response()->json([
                'message' => 'Forbidden',
                'code' => 'TICKET_FORBIDDEN',
            ], 403);
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

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
