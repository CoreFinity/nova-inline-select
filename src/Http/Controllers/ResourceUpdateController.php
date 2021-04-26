<?php

namespace KirschbaumDevelopment\Nova\Http\Controllers;

use Laravel\Nova\Http\Requests\UpdateResourceRequest;

class ResourceUpdateController
{
    public function __invoke(UpdateResourceRequest $request)
    {

        $model = $request->findModelQuery()->lockForUpdate()->firstOrFail();

        $resource = $request->newResourceWith($model);
        $resource->authorizeToUpdate($request);

        return $model->update(request()->except('_method'));
    }
}
