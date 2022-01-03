<?php

namespace App\Http\Controllers;

use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Workspace::class, 'workspace');
    }

    public function index()
    {
        $workspaces = Workspace::where('owner_user_id', Auth::id())->get();
        return response()->json([
            'status'   => true,
            'messages' => $workspaces->count() . ' workspace selected',
            'data'     => $workspaces
        ], 200);
    }

    public function store(StoreWorkspaceRequest $request)
    {
        $data = $request->validated();
        $data['owner_user_id'] = Auth::id();
        $workspace = Workspace::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'store workspace success',
            'data'    => $workspace
        ], 200);
    }

    public function show(Workspace $workspace)
    {
        return response()->json([
            'status'  => true,
            'message' => 'show workspace success',
            'data'    => $workspace
        ], 200);
    }

    public function update(Workspace $workspace, UpdateWorkspaceRequest $request)
    {
        $workspace->update($request->validated());
        return response()->json([
            'status'  => true,
            'message' => 'update workspace success',
            'data'    => $workspace
        ], 200);
    }

    public function destroy(Workspace $workspace)
    {
        $workspace->delete();
        return response()->json([
            'status'  => true,
            'message' => 'delete workspace success'
        ], 200);
    }
}
