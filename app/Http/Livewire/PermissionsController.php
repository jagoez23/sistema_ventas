<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;


class PermissionsController extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }    

    public function render()
    {
        if(strlen($this->search) > 0)
            $permissions = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $permissions = Permission::orderBy('name', 'asc')->paginate($this->pagination);  

            return view('livewire.permissions.permissions', [
                'permissions' => $permissions   
           ])
           ->extends('layouts.theme.app')
           ->section('content');
    }

    public function CreatePermission()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name'];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre del permiso debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Permission::create(['name' => $this->permissionName]);

        $this->emit('permission-added','Se registró el permiso con éxito');
        $this->resetUI();
    }

    public function Edit(Permission $permission)
    {
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;

        $this->emit('show-modal','Show modal');
    }

    public function UpdatePermission()
    {
        $rules = ['permissionName' => "required|min:2|unique:permissions,name, {{$this->selected_id}}"];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre del permiso debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $permission = Permission::find($this->selected_id);
        $permission->name = $this->permissionName;
        $permission->save();

        $this->emit('permission-updated','Se actualizó el permiso con éxito');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();
        if($rolesCount > 0)
        {
            $this->emit('permission-error', 'No se puede eliminar el permiso porque tiene roles asociados');
            return;
        }
        
        Permission::find($id)->delete();
        $this->emit('permission-deleted', 'Se eliminó el permiso con éxito');
        
    }

    public function resetUI()
    {
        $this->permissionName ='';
        $this->search ='';
        $this->selected_id =0;
        $this->resetValidation();
    }
}
