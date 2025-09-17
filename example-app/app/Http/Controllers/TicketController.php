<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $tickets = Ticket::with(['user', 'status', 'category'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else {
            $tickets = Ticket::with(['status', 'category'])
                            ->where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return response()->json($tickets);

    }

    public function show($id)
    {
        return Ticket::with(['user', 'category', 'status'])->orderBy('created_at', 'desc')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $ticket = Ticket::create($request->validate([
            'title' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:categories,id',
        ]));
        return response()->json($ticket, 201);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->validate([
            'title' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:categories,id',
        ]));
        return response()->json($ticket);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
