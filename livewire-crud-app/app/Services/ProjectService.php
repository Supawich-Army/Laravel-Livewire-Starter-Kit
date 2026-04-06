<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ProjectRepository;

class ProjectService
{
    protected $projectRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function saveProject($projectRequest)
    {
        if (!empty($projectRequest['project_logo'])) {
            $projectLogo = $projectRequest['project_logo'];

            # Upload project images
            $projectLogoPath = $projectLogo->store('projects', 'public');

            $projectRequest['project_logo'] = $projectLogoPath;
        }

        $projectRequest['slug'] = $this->generateUniqueSlug($projectRequest['name']);

        return $this->projectRepository->saveProject($projectRequest);
    }

    /**
     * Generate a unique slug for a project.
     *
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    protected function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while ($this->projectRepository->getProjectQuery()
            ->where('slug', $slug)
            ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Function: getAllProjects
     */
    public function getAllProjects()
    {
        return $this->projectRepository->getProjectQuery();
    }

    /**
     * Function: updateProject
     * @param int $projectId
     * @param array $projectRequest
     */
    public function updateProject($projectId, $projectRequest)
    {
        $project = $this->getAllProjects()->find($projectId);

        if ($project) {

            if (!empty($projectRequest['project_logo'])) {
                $projectLogo = $projectRequest['project_logo'];

                # Upload project images
                $projectLogoPath = $projectLogo->store('projects', 'public');

                $projectRequest['project_logo'] = $projectLogoPath;

                if ($project->project_logo && Storage::exists($project->project_logo)) {
                    Storage::delete($project->project_logo);
                }

                $project->project_logo = $projectLogoPath;
            }

            $project->name = $projectRequest['name'];
            $project->slug = $this->generateUniqueSlug($projectRequest['name'], $projectId);
            $project->description = $projectRequest['description'];
            $project->status = $projectRequest['status'];
            $project->deadline = $projectRequest['deadline'];

            return $project->save();
        }
    }


    /**
     * Function: deleteProject
     * @param int $projectId
     */
    public function deleteProject($projectId)
    {
        $project = $this->getAllProjects()->find($projectId);

        if ($project) {
            return $project->delete();
        }
    }
}
