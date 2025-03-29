<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversations;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class CommentsList extends Component
{
    public $conversationId;
    public $conversation;
    public $isAdmin = false;

    // Active le rafraîchissement en écoutant l'événement commentAdded
    protected $listeners = ['commentAdded' => 'refreshComments'];

    public function mount($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->loadConversation();

        // Vérifier si l'utilisateur est admin ou modérateur
        $user = Auth::user();
        $this->isAdmin = $user && ($user->role === 'Admin' || $user->role === 'Moderator');
    }

    public function refreshComments()
    {
        $this->loadConversation();
    }

    private function loadConversation()
    {
        $this->conversation = Conversations::with([
            'comments' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'comments.user'
        ])->find($this->conversationId);
    }

    public function render()
    {
        return view('livewire.comments-list');
    }
}
