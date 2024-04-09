<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Modules\ProjectManagement\Enums\ProjectType;
use Modules\ProjectManagement\Models\Project;

final class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $employees = null;
        if ('employee' === auth()->guard()) {
            $projects = auth()->user()->projects;
        } else {
            $projects = Project::all();

            $employees = Employee::query()->get(['id', 'name']);
        }

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'employees' => $employees,
            'projectTypes' => ProjectType::getSelectArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Projects/ProjectsForm', [
            'employees' => Employee::query()->get(['id', 'name']),
            'projectTypes' => ProjectType::getSelectArray(),
            'project' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'unique:projects,name'],
            'type' => ['required'],
            'members' => ['required', 'array'],
        ]);

        $project = Project::query()->create($validatedData);
        $project->employees()->sync($validatedData['members']);

        return redirect()->route('projects.index')->with('message', 'Project created.');
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
    public function edit(Project $project)
    {
        $project->load('tasks');

        return Inertia::render('Projects/ProjectsForm', [
            'employees' => Employee::query()->get(['id', 'name']),
            'projectTypes' => ProjectType::getSelectArray(),
            'project' => $project->append('members'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', Rule::unique('projects', 'name')->ignore($project->id)],
            'type' => ['required'],
            'members' => ['required', 'array'],
        ]);

        $project->update($validatedData);
        $project->employees()->sync($validatedData['members']);

        return redirect()->route('projects.index')->with('message', 'Project edited.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('message', 'Project deleted.');
    }
}
