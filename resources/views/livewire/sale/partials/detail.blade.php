<div class="connet-sorting mb-2">
    <div class="btn-group">
        <button class="btn btn-dark mr-3" data-toggle="modal" data-target="#modalSearchProduct">
            <i class="fas fa-search">Buscar productos</i>
        </button>

        <button wire:click="printLast" class="btn btn-dark mr-3">
            <i class="fas fa-search">Reimprimir última F7</i>
        </button>
    </div>
</div>

<div class="connet-sorting">
    <div class="connet-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if($total > 0)
                    <div class="table-responsive tblscroll" style="max-height: 650px; overflow: hidden">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th width="10%"></th>
                                    <th class="table-th text-left text-white">Descripción</th>
                                    <th class="table-th text-center text-white">Precio</th>
                                    <th width="13%" class="table-th text-center text-white">Cantidad</th>
                                    <th class="table-th text-center text-white">Total</th>
                                    <th class="table-th text-center text-white">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                    <tr>
                                        <td class="text-center table-th">
                                            @if(count($item->attributes) > 0)
                                                <span>
                                                    <img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen del producto"
                                                        height="90" width="90" class="rounded">
                                                </span>
                                            @endif    
                                        </td>
                                        <td><h6>{{$item->name}}</h6></td>
                                        <td class="text-center">${{number_format($item->price)}}</td>
                                        <td>
                                            <input type="number" id="r{{$item->id}}"
                                                    wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )"
                                                    style="font-size: 1rem!important"
                                                    class="form-control text-center"
                                                    value="{{$item->quantity}}">
                                        </td>
                                        <td class="text-center">
                                            <h6>
                                                ${{number_format($item->price * $item->quantity)}}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <button onclick="Confirm('{{$item->id}}', 'removeItem', '¿Estas seguro eliminar el registro?')" class="btn btn-dark mbmobile">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button wire:click.prevent="decreaseQty({{$item->id}})" class="btn btn-dark mbmobile">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button wire:click.prevent="increaseQty({{$item->id}})" class="btn btn-dark mbmobile">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </td>    
                                    </tr>
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                @else
                    <h5 class="text-center text-muted">Agregar productos a la venta</h5>
                @endif
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">Guardando venta...</h4>
                </div>
            </div>
        </div>
    </div>
</div>