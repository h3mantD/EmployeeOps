<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Actions\Projects;

use Illuminate\Support\Facades\DB;
use Modules\ProjectManagement\Models\Project;
use Throwable;

final class ProjectCRUD
{
    public function create(array $projectData): void
    {
        DB::beginTransaction();
        try {
            $project = Project::query()->create($projectData);
            $project->employees()->sync($projectData['members']);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function update(Project $project, array $projectData): void
    {
        DB::beginTransaction();
        try {
            $project->update($projectData);
            $project->employees()->sync($projectData['members']);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function delete(Project $project): void
    {
        DB::beginTransaction();
        try {
            $project->employees()->detach();
            $project->delete();

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
