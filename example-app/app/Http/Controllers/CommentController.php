<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Comment::with('user')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment' => 'required|string',
            'name' => 'nullable|string',
        ]);
        $user = auth()->user();
        $ticket = \App\Models\Ticket::findOrFail($data['ticket_id']);

        // Set recipient_id based on user_id
        if ($user->id == 2) {
            // Admin sends to ticket owner
            $data['recipient_id'] = $ticket->user_id;
        } else {
            // User sends to admin (user_id 2)
            $data['recipient_id'] = 2;
        }
        $data['user_id'] = $user->id;

        $comment = \App\Models\Comment::create($data);

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->validated());

        $comments = Review::all();
        return ReviewResource::collection($comments);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Review succesfully deleted']);
    }
}
