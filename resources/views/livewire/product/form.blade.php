@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej:">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Código de barras</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 02577">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Costo</label>
            <input type="text" date-type="currency" wire:model.lazy="cost" class="form-control" placeholder="ej: 1500">
            @error('cost') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio</label>
            <input type="text" date-type="currency" wire:model.lazy="price" class="form-control" placeholder="ej: 1500">
            @error('price') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Stock</label>
            <input type="number"  wire:model.lazy="stock" class="form-control" placeholder="ej: 0">
            @error('stock') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Alertas / Inv minímo</label>
            <input type="number"  wire:model.lazy="alert" class="form-control" placeholder="ej: 10">
            @error('alert') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>
            <select wire:model='categoryid'class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option> 
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>   
    </div> 
    
    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" 
            accept="image/x-png, image/gif, image/jpg">
            <label class="custom-file-label">Imagen {{$image}}<label
            @error('image') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>   
</div>


@include('common.modalFooter')