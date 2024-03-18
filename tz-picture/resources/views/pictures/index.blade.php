<div class="row">
    <div class="col-md-12" id="sort-buttons">
        <button class="btn btn-primary" id="sort-by-name">Сортировка по имени</button>
        <button class="btn btn-primary" id="sort-by-date">Сортировка по дате</button>
    </div>
</div>

<div class="row" id="pictures-container">
    @foreach ($pictures as $picture)
        <div class="picture">
            <img src="{{ asset('uploads/' . $picture->name) }}" width="100">
            <p data-name="{{ $picture->name }}">{{ $picture->name }}</p>
            <p data-date="{{ $picture->created_at }}">{{ $picture->created_at }}</p>
            <a href="{{ route('pictures.downloadZip', $picture->name) }}">Скачать</a>
            <a href="{{ asset('uploads/' . $picture->name) }}">Просмотреть оригинал</a>
        </div>
    @endforeach
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var sortAsc = true;

        function sortPicturesByDate() {
            var $pictures = $('#pictures-container .picture').sort(function(a, b) {
                var dateA = new Date($(a).find('[data-date]').data('date'));
                var dateB = new Date($(b).find('[data-date]').data('date'));
                if (sortAsc) {
                    return dateA - dateB;
                } else {
                    return dateB - dateA;
                }
            });
            $('#pictures-container').append($pictures);
        }

        function sortPicturesByName() {
            var $pictures = $('#pictures-container .picture').sort(function(a, b) {
                var nameA = $(a).find('[data-name]').data('name').toLowerCase();
                var nameB = $(b).find('[data-name]').data('name').toLowerCase();
                if (sortAsc) {
                    return nameA > nameB ? 1 : -1;
                } else {
                    return nameA < nameB ? 1 : -1;
                }
            });
            $('#pictures-container').append($pictures);
        }

        $('#sort-by-date').click(function() {
            sortPicturesByDate();
            sortAsc = !sortAsc;
        });

        $('#sort-by-name').click(function() {
            sortPicturesByName();
            sortAsc = !sortAsc;
        });
    });
</script>
