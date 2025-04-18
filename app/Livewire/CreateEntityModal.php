<?php

namespace App\Livewire;

use App\Models\Entities;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class CreateEntityModal extends Component
{
    use WithFileUploads;

    public $data = [
        'name' => '',
        'description' => '',
    ];

    public $image;

    public function create()
    {
        $validated = $this->validate([
            'data.name' => 'required|string|max:255',
            'data.description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $entity = Entities::create($validated['data']);

        if ($this->image) {
            $entity->addMedia($this->image->getRealPath())
                ->toMediaCollection('image');
        }

        $this->dispatch('entity-created', entity: $entity);
        $this->reset(['data', 'image']);
        $this->dispatch('entity-modal-closed');
    }

    public function render()
    {
        return view('livewire.create-entity-modal');
    }
}
