<?php

namespace KirschbaumDevelopment\Nova\Http\Controllers;

use Laravel\Nova\Http\Requests\UpdateResourceRequest;

class ResourceUpdateController
{
    public function __invoke(UpdateResourceRequest $request)
    {

        $model = $request->findModelQuery()->lockForUpdate()->firstOrFail();

        return $model->update(request()->only(
            request()->get('allowedFields')
        ));
    }
}
