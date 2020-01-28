<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\SolarProjectResource;
use App\Http\Resources\SolarProjectCollection;
use App\Models\SolarProject;

class SolarProjectsController extends Controller
{
    public function index()
    {
        return new SolarProjectCollection(SolarProject::paginate());
    }

    public function store(Request $request)
    {
        $data = $this->validate($request->all(), [
            'system_size' => 'numeric|present|nullable',
            'title' => 'string|required',
            'site_latitude' => 'numeric|required',
            'site_longitude' => 'numeric|required',
        ]);

        $solarProject = SolarProject::create($data);

        return new SolarProjectResource($solarProject);
    }

    public function show(SolarProject $solar_project)
    {
        return new SolarProjectResource($solar_project);
    }

    public function update(Request $request, SolarProject $solar_project)
    {
        if ($request->isMethod('patch')) {
            $data = $this->validate($request, [
                'system_size' => 'numeric|nullable',
                'title' => 'string',
                'site_latitude' => 'numeric',
                'site_longitude' => 'numeric',
            ]);
        } else {
            $data = $this->validate($request, [
                'system_size' => 'numeric|present|nullable',
                'title' => 'string|required',
                'site_latitude' => 'numeric|required',
                'site_longitude' => 'numeric|required',
            ]);
        }

        $solar_project->update($data);

        return new SolarProjectResource($solar_project);
    }

    public function destroy(SolarProject $solar_project)
    {
        $solar_project->delete();

        return response()->noContent();
    }
}
