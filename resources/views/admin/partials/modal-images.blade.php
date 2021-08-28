<x-modal title="Koleksi Gambar">
    <div class="modal-body manufacturer-image-embed">
        <select class="image-picker show-html select" name="images">
            @if(isset($images))
                <option value=""></option>
                @foreach($images as $key=>$image)
                    <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->image_id}}"> {{$image->image_id}} </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" id="select-image" data-dismiss="modal" class="btn btn-success">Pilih</button>
    </div>
</x-modal>