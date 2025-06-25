<div class="btn-group" role="group">
    <form action="{{ $form_url }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" title="Hapus"><i class="fas fa-trash"></i>Hapus</button>
        <a href="{{ $edit_url }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
    </form>
</div>
