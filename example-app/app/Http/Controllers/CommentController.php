<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Ticket;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    protected function loadRelations(Comment $comment)
    {
        return $comment->load(['ticket', 'user', 'recipient']);
    }

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
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();
        $ticket = Ticket::findOrFail($data['ticket_id']);
        $this->authorize('create', $ticket);

        $user = Auth::user();
        $ticket = \App\Models\Ticket::findOrFail($data['ticket_id']);

        if ($user->id !== $ticket->user_id && $user->id !== $ticket->agent_id) {
            return ApiResponse::forbidden(
                'You are not authorized to comment on this ticket.',
                'COMMENT_FORBIDDEN',
                ['ticket_id' => $ticket->id]
            );
        }

        $data['user_id'] = $user->id;
        $data['recipient_id'] = $user->id === $ticket->user_id
            ? $ticket->agent_id
            : $ticket->user_id;

        $comment = \App\Models\Comment::create($data);

        $recipient = $comment->recipient;
        if ($recipient) {
            $recipient->notify(new NewCommentNotification($comment));
        }

        $comments = Comment::with('user')
        ->where('ticket_id', $data['ticket_id'])
        ->get();

        return (new CommentResource($this->loadRelations($comment)))
            ->response()
            ->setStatusCode(201);
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
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        $comments = Comment::with(['ticket', 'user', 'recipient'])->get();
        return CommentResource::collection($comments);
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
