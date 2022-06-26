<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target=
                        "#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">Tipo</th>
                                <th class="table-th text-white text-center">Valor</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $coin)
                                <tr>
                                    <td><h6>{{$coin->type}}</h6></td>
                                    <td><h6 class="text-center">${{number_format($coin->value)}}</h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/denominations/' . $coin->image) }}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)"
                                            wire:click="Edit({{$coin->id}})"
                                            class="btn btn-dark mtmobile" title="Editar">
                                                <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                                onclick="Confirm('{{$coin->id}}')"
                                                class="btn btn-dark" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach    
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.denomination.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg =>{
            $('#theModal').modal('show')
        });
        window.livewire.on('item-added', msg =>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('item-updated', msg =>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('item-deleted', msg =>{
            //noty
        });
        window.livewire.on('modal-hide', msg =>{
            $('#theModal').modal('hide')
        });
        $('#theModal').on('hidden.bs.modal', function(e) {
            $('.er').css('display','none')
        });
    });

    function Confirm(id,products)
    {
        if(products > 0)
        {
            swal('No se puede eliminar la categoría porque tiene productos relacionados')
            return;
        }
        swal({
            title: 'CONFIRMAR',
            text: 'Estas seguro de eliminar el registro?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }
        })
    }

</script>
