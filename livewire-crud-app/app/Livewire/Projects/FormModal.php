<?php

namespace App\Livewire\Projects;

use Flux\Flux;
use App\Models\Project;
use App\Services\ProjectService;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class FormModal extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:100')]
    public $name = null;

    #[Validate('required|string|max:255')]
    public $description = null;

    #[Validate('required|date|after_or_equal:today')]
    public $deadline = null;

    #[Validate('required|in:pending,in-progress,completed,cancelled')]
    public $status = 'pending';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:5120')]
    public $project_logo = null;

    public $projectId = null;

    public $isView = false;

    public $existingImage = null;

    /**
     * Function: saveProject
     */
    public function saveProject(ProjectService $projectService)
    {

        // $this->authorize('create', Project::class);

        # Validating form here
        $validatedProjectRequest = $this->validate();

        if ($this->projectId) {
            $projectService->updateProject($this->projectId, $validatedProjectRequest);
            $message = 'Project updated successfully.';
        } else {
            $projectService->saveProject($validatedProjectRequest);
            $message = 'Project created successfully.';
        }

        $this->reset(['name', 'description', 'deadline', 'project_logo', 'projectId', 'existingImage']);
        $this->status = 'pending';

        $this->dispatch(
            'flash',
            message: $message,
            type: 'success'
        );

        $this->dispatch('refresh-project-listing');

        Flux::modal('project-modal')->close();
    }

    #[On('open-project-modal')]
    public function projectDetail($mode, $projectId = null)
    {
        $this->isView = $mode === 'view';

        if ($mode === 'create') {
            $this->isView = false;
            $this->projectId = null;
            $this->existingImage = null;
            $this->reset();
        } else {
            // mode view details
            $project = Project::find($projectId);

            if ($project) {
                $this->projectId = $project->id;

                $this->name             = $project->name;
                $this->description      = $project->description;
                $this->deadline         = $project->deadline;
                $this->status           = $project->status;
                $this->existingImage    = $project->project_logo;
            }
        }
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
