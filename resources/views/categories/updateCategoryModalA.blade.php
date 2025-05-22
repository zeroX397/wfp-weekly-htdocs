<div class="modal fade" id="update-category-modal-a" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<form action="{{ route(
    'categories.update',
    $category->id
) }}" method="post" class="m-3">
    <div class="modal-header">
        <h5 class="modal-title">Edit Category/h5>
            <button type="button" class="btn-close" data-hs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Category None</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}">
        </div>
    