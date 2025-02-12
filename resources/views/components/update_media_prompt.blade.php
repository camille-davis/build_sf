<div class="prompt-container" id="update-media">
    <div class="prompt">
        <button class="close" title="Close">
            <i class="fas fa-times"></i>
        </button>
        <h2>Update Media</h2>
        <form method="POST" action="" class="update-media">

            @csrf
            @method('PUT')

            <div class="field">
                <label for="alt">Image Description</label>
                <input type="text" name="alt" placeholder="A short description of the image." value="" maxlength="160" />
            </div>

            @if ($settings->projects == 1)
            <div class="field project-id">
                <label for="project_id">Project ID</label>
                <input type="number" name="project_id" placeholder="Project ID#" value=""/>
            </div>
            @endif

            <button type="submit" class="save">Save</button>

        </form>
    </div>
</div><!-- end #update-media -->
