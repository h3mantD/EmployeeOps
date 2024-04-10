<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Http\Controllers;

use App\Enums\LastOperationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Modules\ProjectManagement\Enums\TaskStatus;
use Modules\ProjectManagement\Enums\TaskType;
use Modules\ProjectManagement\Models\Project;
use Modules\ProjectManagement\Models\Task;

final class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project): Response
    {
        return Inertia::render('Projects/Index', [
            'tasks' => $project->tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project, Request $request): Response
    {
        return Inertia::render('Tasks/TaskForm', [
            'project' => $project,
            'statuses' => TaskStatus::getSelectArray(),
            'types' => TaskType::getSelectArray(),
            'task' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'unique:tasks,name'],
            'type' => ['required'],
            'status' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $validatedData['project_id'] = $project->id;

        $project->tasks()->create($validatedData);

        return redirect()->route('projects.edit', ['project' => $project])->with('message', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        // code
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        return Inertia::render('Tasks/TaskForm', [
            'project' => $project,
            'statuses' => TaskStatus::getSelectArray(),
            'types' => TaskType::getSelectArray(),
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Project $project, Task $task, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', Rule::unique('tasks', 'name')->ignore($task->id)],
            'type' => ['required'],
            'status' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $validatedData['last_operation'] = LastOperationType::UPDATE;

        $task->update($validatedData);

        return redirect()->route('projects.edit', ['project' => $project])->with('message', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('projects.edit', ['project' => $project])->with('message', 'Task deleted.');
    }
}
