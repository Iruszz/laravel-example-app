<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;

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
        return Ticket::with(['user', 'category', 'status'])->orderBy('created_at', 'desc')->findOrFail($id);
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['status_id'] = 1;

        $ticket = Ticket::create($data);

        return response()->json($ticket, 201);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->validated());

        return response()->json($ticket);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
