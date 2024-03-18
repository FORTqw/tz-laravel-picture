<form action="{{ route('pictures.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="pictures">Изображения</label>
        <input type="file" class="form-control-file" id="pictures" name="pictures[]" multiple maxlength="5">
    </div>

    <button type="submit" class="btn btn-primary">Загрузить изображения</button>
</form>
