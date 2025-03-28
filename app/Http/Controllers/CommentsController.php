<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\Conversations;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Ajoute un commentaire à une conversation existante
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'comment' => 'required|string|max:2000',
        ]);

        $conversation = Conversations::findOrFail($request->conversation_id);
        $project = $conversation->project;

        // Vérifier que l'utilisateur a accès au projet
        $user = Auth::user();
        if (!$project->users->contains($user) && $user->role !== 'Admin' && $user->role !== 'Moderator') {
            abort(403, 'Vous n\'avez pas accès à ce projet.');
        }

        // Vérifier que l'utilisateur a accès à la conversation admin si c'est le cas
        if ($conversation->type === 'admin' && $user->role !== 'Admin' && $user->role !== 'Moderator') {
            abort(403, 'Vous n\'avez pas accès à cette conversation.');
        }

        // Créer le commentaire
        $comment = new Comments();
        $comment->comment = $request->comment;
        $comment->user_id = $user->id;
        $comment->conversation_id = $request->conversation_id;
        $comment->save();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.');
    }

    /**
     * Crée une nouvelle conversation avec un premier commentaire
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createConversation(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'type' => 'required|in:public,admin',
            'comment' => 'required|string|max:2000',
        ]);

        $project = Projects::findOrFail($request->project_id);

        // Vérifier que l'utilisateur a accès au projet
        $user = Auth::user();
        if (!$project->users->contains($user) && $user->role !== 'Admin' && $user->role !== 'Moderator') {
            abort(403, 'Vous n\'avez pas accès à ce projet.');
        }

        // Vérifier que l'utilisateur a accès à la conversation admin si c'est le cas
        if ($request->type === 'admin' && $user->role !== 'Admin' && $user->role !== 'Moderator') {
            abort(403, 'Vous n\'avez pas accès à cette conversation.');
        }

        // Vérifier qu'une conversation du même type n'existe pas déjà
        $existingConversation = $project->conversations()->where('type', $request->type)->first();
        if ($existingConversation) {
            // Si elle existe, on ajoute juste un commentaire
            $comment = new Comments();
            $comment->comment = $request->comment;
            $comment->user_id = $user->id;
            $comment->conversation_id = $existingConversation->id;
            $comment->save();
        } else {
            // Sinon, créer la conversation et le commentaire
            $conversation = new Conversations();
            $conversation->project_id = $request->project_id;
            $conversation->type = (string) $request->type;
            $conversation->save();

            $comment = new Comments();
            $comment->comment = $request->comment;
            $comment->user_id = $user->id;
            $comment->conversation_id = $conversation->id;
            $comment->save();
        }

        return redirect()->back()->with('success', 'Discussion démarrée avec succès.');
    }
}
