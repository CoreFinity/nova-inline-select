<?php

namespace KirschbaumDevelopment\Nova;

use Illuminate\Support\Facades\URL;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class InlineSelect extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'inline-select';

    /**
     * Set the options for the select menu.
     *
     * @param  array|\Closure  $options
     *
     * @return $this
     */
    public function options($options)
    {
        if (is_callable($options)) {
            $options = call_user_func($options);
        }

        return $this->withMeta([
            'options' => collect($options ?? [])->map(function ($label, $value) {
                return is_array($label) ? $label + ['value' => $value] : ['label' => $label, 'value' => $value];
            })->values()->all(),
        ]);
    }

    /**
     * Allow inline select to auto-update field value on change on detail view.
     *
     * @return $this
     */
    public function disableTwoStepOnDetail()
    {
        return $this->withMeta(['detailTwoStepDisabled' => true]);
    }

    /**
     * Allow inline select to auto-update field value on change on index view.
     *
     * @return $this
     */
    public function disableTwoStepOnIndex()
    {
        return $this->withMeta(['indexTwoStepDisabled' => true]);
    }

    /**
     * Allow inline select to auto-update field value on change on index view.
     *
     * @return $this
     */
    public function disableTwoStepOnLens()
    {
        return $this->disableTwoStepOnIndex();
    }

    /**
     * Display values using their corresponding specified labels.
     *
     * @return $this
     */
    public function displayUsingLabels()
    {
        return $this->withMeta(['displayUsingLabels' => true]);
    }

    /**
     * Enable inline editing on detail view.
     *
     * @return $this
     */
    public function inlineOnDetail($inline = true, $reloadOnUpdate = false)
    {
        return $this->withMeta(['inlineDetail' => $inline, 'inlineDetailReloadOnUpdate' => $reloadOnUpdate]);
    }

    /**
     * Enable inline editing on index view.
     *
     * @return $this
     */
    public function inlineOnIndex()
    {
        return $this->withMeta(['inlineIndex' => true]);
    }

    /**
     * Enable inline editing on index view.
     *
     * @return $this
     */
    public function inlineOnLens()
    {
        return $this->inlineOnIndex();
    }

        /**
     * Get additional meta information to merge with the element payload.
     *
     * @return array
     */
    public function meta()
    {
        $request = app(NovaRequest::class);

        return  array_merge($this->meta, [
            'inlineDetailUpdateLink' => URL::temporarySignedRoute('inline-select.update', now()->addMinutes(60),   [
                'resource' =>  $request->route('resource'),
                'resourceId' =>  $request->route('resourceId'),
                'allowedFields' => [
                    $this->attribute
                ]
            ])
        ]);
    }
}
