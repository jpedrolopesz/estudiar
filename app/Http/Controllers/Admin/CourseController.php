<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Code\UpdateDraggableCodeAction;
use App\Actions\Task\GetTasksGroupedBySectionAction;
use App\Actions\Task\UpdateDraggableTaskAction;
use App\Actions\Course\CreateCoursetAction;
use App\Actions\Course\GetCourseCodesChartDataAction;
use App\Actions\Course\GetProjectTaskAssignmentChartDataAction;
use App\Actions\Course\ToggleArchiveStatusAction;
use App\Actions\Course\ToggleFavoriteStatusAction;
use App\Actions\Course\UpdateCourseAction;
use App\Actions\User\GetAllUsersAction;
use App\Data\Project\CreateProjectData;
use App\Data\Project\UpdateProjectData;
use App\Enums\CodeTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class CourseController extends Controller
{
    public function create()
    {
        return Inertia::modal('Project/Create')->with([
            'users' => UserResource::collection(GetAllUsersAction::run(['perPage' => 10000])),
        ])->baseRoute('index');
    }

    public function store(CreateProjectData $data)
    {
        $project = CreateCoursetAction::run($data);

        return Redirect::route('projects.show', $project);
    }

    public function edit(Project $project)
    {
        $prev = url()->previous() ?? '/';

        session()->put('rtn_path', $prev);

        return Inertia::modal('Project/Edit')->with([
            'project' => ProjectResource::make($project->load('members')),
            'users' => UserResource::collection(GetAllUsersAction::run(['perPage' => 10000])),
        ])->baseRoute('index');
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function update(UpdateProjectData $data, Project $project)
    {
        $this->authorize('update', $project);

        UpdateCourseAction::run(data: $data, project: $project);

        $path = session()->pull('rtn_path', 'index');

        if ($data->source == 'partial') {
            return Redirect::back()->success('Project updated');
        }

        return Redirect::to($path)->success('Project updated');

    }

    /**
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function overview(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $filters = $request->all();

        return Inertia::render('Project/Overview', [
            'project' => new ProjectResource($project),
            'chart_data' => [
                'section' => GetCourseCodesChartDataAction::run(
                    user: Auth::user(),
                    project: $project,
                    field: 'section_id',
                    type: CodeTypes::TASK_SECTION->value,
                    filters: $filters
                ),
                'priority' => GetCourseCodesChartDataAction::run(
                    user: Auth::user(),
                    project: $project,
                    field: 'priority_id',
                    type: CodeTypes::TASK_PRIORITY->value,
                    filters: $filters
                ),
                'type' => GetCourseCodesChartDataAction::run(
                    user: Auth::user(),
                    project: $project,
                    field: 'type_id',
                    type: CodeTypes::TASK_TYPE->value,
                    filters: $filters
                ),
                'assignee' => GetProjectTaskAssignmentChartDataAction::run(
                    user: Auth::user(),
                    project: $project,
                    field: 'assignee_id',
                    filters: $filters
                ),
                'reporter' => GetProjectTaskAssignmentChartDataAction::run(
                    user: Auth::user(),
                    project: $project,
                    field: 'reporter_id',
                    filters: $filters
                ),
            ],
        ]);
    }

    /**
     * @return JsonResponse|Response
     *
     * @throws AuthorizationException
     */
    public function list(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $filters = $request->all();

        return Inertia::render('Project/List', [
            'project' => new ProjectResource($project->load('members', 'codes')),
            'sections' => GetTasksGroupedBySectionAction::run($project),
            'filters' => $filters,
        ]);
    }

    /**
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function board(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        return Inertia::render('Project/Board', [
            'project' => new ProjectResource($project->load('members', 'codes')),
            'sections' => GetTasksGroupedBySectionAction::run($project),
        ]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function updateDraggable(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        if ($request->type == 'task') {
            UpdateDraggableTaskAction::run($request->payload);
        }

        if ($request->type == 'section') {
            UpdateDraggableCodeAction::run($request->payload);
        }

        return Redirect::back();
    }

    /**
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function toggleArchive(Project $project)
    {
        $this->authorize('manage', $project);
        $current = $project->isArchived();
        $message = $current
            ? 'Project has been unarchived'
            : 'Project has been archived';
        ToggleArchiveStatusAction::run($project);

        return Redirect::back()->success($message);
    }

    /**
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function toggleFavorite(Project $project)
    {
        $this->authorize('view', $project);
        $current = Auth::user()->hasFavedProject($project);
        $message = $current
            ? 'Project has been removed from your favorites'
            : 'Project has been added to your favorites';
        ToggleFavoriteStatusAction::run($project, Auth::user());

        return Redirect::back()->success($message);
    }
}
