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

        $tickets = Ticket::with(['user', 'status', 'category'])
                        ->when(!$user->is_admin, function($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();


        return response()->json($tickets);
    }

    public function show($id)
    {   
        $users = User::all();
        return Ticket::with(['user', 'category', 'status'])->findOrFail($id);
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['status_id'] = 1;

        $ticket = Ticket::create($data);

        return response()->json($ticket, 201);
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        $tickets = Ticket::all();
        return response()->json($tickets);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
