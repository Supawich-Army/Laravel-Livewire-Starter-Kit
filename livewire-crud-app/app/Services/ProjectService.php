<?php

namespace App\Services;

use Illuminate\Support\Str;
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

        $projectRequest['slug'] = Str::slug($projectRequest['name']);

        return $this->projectRepository->saveProject($projectRequest);
    }

    /**
     * Function: getAllProjects
     */
    public function getAllProjects()
    {
        return $this->projectRepository->getProjectQuery();
    }
}
