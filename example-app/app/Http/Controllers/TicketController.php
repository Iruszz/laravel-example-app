<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::with(['user', 'category'])->get();
    }

    public function show($id)
    {
        return Ticket::with(['user', 'category'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $ticket = Ticket::create($request->validate([
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]));
        return response()->json($ticket, 201);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->validate([
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]));
        return response()->json($ticket);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
