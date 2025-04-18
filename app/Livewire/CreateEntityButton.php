<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Entities;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class CreateEntityButton extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $image;
    public $isOpen = false;

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'description', 'image']);
    }

    public function create()
    {
        Log::info('CreateEntityButton::create() called', [
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image ? 'present' : 'absent'
        ]);

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        Log::info('Validation passed', ['validated' => $validated]);

        try {
            $entity = Entities::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            Log::info('Entity created', ['entity' => $entity->toArray()]);

            if ($this->image) {
                $entity->addMedia($this->image->getRealPath())
                    ->toMediaCollection('image');
                Log::info('Image added to entity');
            }

            $this->closeModal();
            $this->dispatch('entity-created', entity: $entity);

            Notification::make()
                ->title('Établissement créé avec succès')
                ->success()
                ->send();

            Log::info('Entity creation completed successfully');
        } catch (\Exception $e) {
            Log::error('Error creating entity', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            Notification::make()
                ->title('Erreur lors de la création')
                ->body('Une erreur est survenue lors de la création de l\'établissement: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.create-entity-button');
    }
}
