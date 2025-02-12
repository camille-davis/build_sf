<form method="POST" action="/admin/media" enctype="multipart/form-data" class="upload-media">
    @csrf
    <div class="field">
        <label for="file">Image Files</label>
        <div class="input-with-button">
            <input type="file" name="file[]" multiple />
            <button type="submit">Upload</button>
        </div>
    </div>
    @if (isset($id))
        <input type="number" name="project_id" placeholder="Project ID#" value="{{ $id }}" readonly />
    @endif
</form>
