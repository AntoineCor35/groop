<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comments;
use App\Models\Conversations;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;

class CreateComment extends Component
{
    public $conversationId;
    public $projectId;
    public $comment = '';
    public $type = 'public'; // public ou admin
    public $isAdmin = false;

    public function mount($conversationId = null, $projectId = null, $type = 'public')
    {
        $this->conversationId = $conversationId;
        $this->projectId = $projectId;
        $this->type = $type;

        // Vérifier si l'utilisateur est admin ou modérateur
        $user = Auth::user();
        $this->isAdmin = $user && ($user->role === 'Admin' || $user->role === 'Moderator');

        // Vérifier si l'utilisateur peut accéder à une conversation admin
        if ($this->type === 'admin' && !$this->isAdmin) {
            $this->type = 'public';
        }
    }

    public function addComment()
    {
        // Valider le commentaire
        $this->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        // Deux cas possibles : créer une nouvelle conversation ou ajouter à une existante
        if ($this->conversationId) {
            // Cas 1 : Ajouter un commentaire à une conversation existante
            $conversation = Conversations::findOrFail($this->conversationId);
            $project = $conversation->project;

            // Vérifier que l'utilisateur a accès au projet
            if (!$project->users->contains($user) && !$this->isAdmin) {
                session()->flash('error', 'Vous n\'avez pas accès à ce projet.');
                return;
            }

            // Vérifier que l'utilisateur a accès à la conversation admin si c'est le cas
            if ($conversation->type === 'admin' && !$this->isAdmin) {
                session()->flash('error', 'Vous n\'avez pas accès à cette conversation.');
                return;
            }

            // Créer le commentaire
            $newComment = new Comments();
            $newComment->comment = $this->comment;
            $newComment->user_id = $user->id;
            $newComment->conversation_id = $this->conversationId;
            $newComment->save();
        } else if ($this->projectId) {
            // Cas 2 : Créer une nouvelle conversation avec un premier commentaire
            $project = Projects::findOrFail($this->projectId);

            // Vérifier que l'utilisateur a accès au projet
            if (!$project->users->contains($user) && !$this->isAdmin) {
                session()->flash('error', 'Vous n\'avez pas accès à ce projet.');
                return;
            }

            // Vérifier que l'utilisateur a accès à la conversation admin si c'est le cas
            if ($this->type === 'admin' && !$this->isAdmin) {
                session()->flash('error', 'Vous n\'avez pas accès à cette conversation.');
                return;
            }

            // Vérifier qu'une conversation du même type n'existe pas déjà
            $existingConversation = $project->conversations()->where('type', $this->type)->first();

            if ($existingConversation) {
                // Si elle existe, on ajoute juste un commentaire
                $newComment = new Comments();
                $newComment->comment = $this->comment;
                $newComment->user_id = $user->id;
                $newComment->conversation_id = $existingConversation->id;
                $newComment->save();

                // Mettre à jour l'ID de la conversation
                $this->conversationId = $existingConversation->id;
            } else {
                // Sinon, créer la conversation et le commentaire
                $conversation = new Conversations();
                $conversation->project_id = $this->projectId;
                $conversation->type = $this->type;
                $conversation->save();

                $newComment = new Comments();
                $newComment->comment = $this->comment;
                $newComment->user_id = $user->id;
                $newComment->conversation_id = $conversation->id;
                $newComment->save();

                // Mettre à jour l'ID de la conversation
                $this->conversationId = $conversation->id;
            }
        } else {
            session()->flash('error', 'Erreur: aucun projet ou conversation spécifié.');
            return;
        }

        // Réinitialiser le champ de commentaire
        $this->comment = '';

        // Émettre un événement pour rafraîchir la liste des commentaires
        $this->dispatch('commentAdded');

        session()->flash('success', 'Commentaire ajouté avec succès.');
    }

    public function render()
    {
        return view('livewire.create-comment');
    }
}
