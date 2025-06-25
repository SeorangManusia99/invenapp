<div class="btn-group" role="group">
    <form action="{{ $formUrl }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
        <a href="{{ $editUrl }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
    </form>
</div>