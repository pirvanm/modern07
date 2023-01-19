<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Intranet\DualListBox\DualListBox;

class EditPermissions extends Action
{
    use InteractsWithQueue, Queueable;

    public $model;

    public function __construct($model)
    {
        $this->model = $model;

        if(!is_null($resourceId = request('resourceId'))){
            $this->model = Role::find($resourceId);
        }
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if ((!$fields->sync && $models[0]->permissions->count()) || $fields->sync) {
            $models[0]->permissions()->sync($fields->sync);
        }

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $permissions = DB::table('permissions')
            ->whereNotIn('id', $this->model->permissions()->get()->pluck(['id']))
            ->orderBy('name')
            ->select(['id', 'name', 'display_name'])
            ->get();

        return [
            DualListbox::make('Permissions', 'permissions')->setListData(json_encode($this->groupPermissionsByNamePrefix($permissions)))
                ->hideWhenCreating()
                ->hideFromIndex()
                ->hideFromDetail()
                ->withMeta(['value' => json_encode($this->groupPermissionsByNamePrefix($this->model->permissions))])
                ->withMeta(['role' => $this->model]),
        ];
    }

    protected function groupPermissionsByNamePrefix(Collection $permissions)
    {
        $listData = [];
        $label = '';
        $index = 0;
        if (count($permissions)) {
            foreach ($permissions as $permission) {
                $bits = explode('_', $permission->name);

                if ($label !== $bits[0]) {
                    $index++;
                }

                $listData[$index]['label'] = $bits[0];
                $listData[$index]['items'][] = ['id' => $permission->id, 'name' => $permission->display_name];
                $label = $bits[0];
            }
        }

        return $listData;
    }
}
