<?php

namespace App\Livewire\Projects;

use Flux\Flux;
use App\Services\ProjectService;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class FormModal extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:100')]
    public $name = null;

    #[Validate('required|string|max:255')]
    public $description = null;

    #[Validate('required|string')]
    public $deadline = null;

    #[Validate('required|string')]
    public $status = 'pending';

    #[Validate('nullable|image|max:5120')]
    public $project_logo = null;

    /**
     * Function: saveProject
     */
    public function saveProject(ProjectService $projectService)
    {
        # Validating form here
        $validatedProjectRequest = $this->validate();

        $projectService->saveProject($validatedProjectRequest);

        $this->reset();

        $this->dispatch('flash', [
            'message' => 'Project created successfully.',
            'type' => 'success',
        ]);

        Flux::modal('project-modal')->close();
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
