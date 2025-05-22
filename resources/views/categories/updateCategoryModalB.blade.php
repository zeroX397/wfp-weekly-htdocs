<div class="modal-header">
    <h5 class="modal-title"> Edit Category</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Category Name </label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
        onclick="saveDataUpdate('{{ $category->Id}}'">Submit</button>
    <button type="button" class="btn btn-secondary data-bs-dismiss modal">Cancel</button>
</div>