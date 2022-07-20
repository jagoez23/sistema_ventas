<?php

namespace App\Http\Livewire;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use App\Models\Sale;

class UsersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $profile;
    public $pageTitle, $componentName, $search;
    private $pagination = 3;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $data = User::where('name', 'like', '%' . $this->search . '%')
            ->select('*')->orderBy('name','asc')->paginate($this->pagination);
        else
            $data = User::select('*')->orderBy('name','asc')->paginate($this->pagination);
                
        return view('livewire.user.users', [
            'data' => $data,
            'roles' => Role::orderBy('name','asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $this->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('show-modal', 'open!');
    }

    protected $listeners = [
        'deleteRow' => 'Destroy',
        'resetUI' => 'resetUI'
    ];

    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
        ];

        $messages = [
            'name.required' => 'El nombre del usuario es requerido',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'Ingresa una dirección de correo valida',
            'email.unique' => 'El correo electrónico ya esta registrado',
            'status.required' => 'Selecciona el estado del usuario',
            'status.not_in' => 'Selecciona el estado',
            'profile.required' => 'Seleccion el perfil/role del usuario',
            'profile.not_in' => 'Seleccion un perfil/role del usuario',
            'password.required' => 'El password es requerido',
            'password.min' => 'El password debe tener al menos 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        if($this->image) 
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added', 'Usuario registrado de forma correcta');
    }

    public function Update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'El nombre del usuario es requerido',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'Ingresa una dirección de correo valida',
            'email.unique' => 'El correo electrónico ya esta registrado',
            'status.required' => 'Selecciona el estado del usuario',
            'status.not_in' => 'Selecciona el estado',
            'profile.required' => 'Seleccion el perfil/role del usuario',
            'profile.not_in' => 'Seleccion un perfil/role del usuario',
            'password.required' => 'El password es requerido',
            'password.min' => 'El password debe tener al menos 3 caracteres'
        ];
        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        if($this->image) 
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageTemp = $user->image;
            $user->image = $customFileName;
            $user->save();

            if($imageTemp !=null)
            {
                if(file_exists('storage/users/' . $imageTemp)) {
                    unlink('storeage/users/' . $imageTemp);
                }
            }
        }
        $this->resetUI();
        $this->emit('user-updated', 'Usuario actualizado de forma correcta');
    }

    public function Destroy(User $user)
    {
        if($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if($sales > 0) {
                $this->emit('user-withsales', 'No se puede eliminar el usuario, porque tiene ventas registradas');
            }else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted', 'Usuario eliminado de forma correcta');
            }
        }
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->search = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }
}
