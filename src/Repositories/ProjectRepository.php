<?php

declare(strict_types=1);

/*
 * This file is part of YouTrack REST PHP.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\YouTrack\Repositories;

use Cog\YouTrack\Contracts\ProjectRepository as ProjectRepositoryContract;
use Cog\YouTrack\Contracts\YouTrackClient as YouTrackClientContract;
use Cog\YouTrack\Entity\Project\Project;

/**
 * Class ProjectRepository.
 *
 * @package Cog\YouTrack\Repositories
 */
class ProjectRepository implements ProjectRepositoryContract
{
    /**
     * @var \Cog\YouTrack\Contracts\YouTrackClient
     */
    private $youTrack;

    /**
     * @param \Cog\YouTrack\Contracts\YouTrackClient $youTrack
     */
    public function __construct(YouTrackClientContract $youTrack)
    {
        $this->youTrack = $youTrack;
    }

    /**
     * @see https://www.jetbrains.com/help/youtrack/standalone/2017.2/GET-Projects.html
     *
     * @return \Cog\YouTrack\Entity\Project\Project[]
     */
    public function all()
    {
        $projectsData = $this->youTrack->get('/rest/admin/project');

        $projects = [];
        foreach ($projectsData as $projectData) {
            $project = new Project();
            $project->hydrate($projectData);

            $projects[] = $project;
        }

        return $projects;
    }

    /**
     * @see https://www.jetbrains.com/help/youtrack/standalone/2017.2/GET-Project.html
     *
     * @param string $id
     * @return \Cog\YouTrack\Entity\Project\Project
     */
    public function find($id)
    {
        $projectData = $this->youTrack->get('/rest/admin/project/' . $id);

        $project = new Project();
        $project->hydrate($projectData);

        return $project;
    }
}
