<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->is_admin) {
            return ApiResponse::forbidden('You are not authorized to view notes.');
        }

        $notes = Note::with('user')->get();

        return NoteResource::collection($notes);
    }

    public function store(StoreNoteRequest $request)
    {
        $this->authorize('create', Note::class);
        $user = Auth::user();

        $data = $request->validated();
        $data['user_id'] = $user->id;

        $note = Note::create($data);

        return (new NoteResource($note))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);
        $note->update($request->validated());

        $note->load([]);
        return new NoteResource($note);
    }
}
