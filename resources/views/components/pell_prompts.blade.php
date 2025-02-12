<div class="prompt-container" id="img-prompt">
    <div class="prompt">
        <button class="close" title="Close">
            <i class="fas fa-times"></i>
        </button>
        <button class="select">Select from Media</button>
        <div class="field">
            <label for="image-url">Image URL</label>
            <input type="text" name="image-url" placeholder="/img/example.jpeg" />
        </div>
        <div class="field">
            <label for="image-alt">Image Alt Text</label>
            <input type="text" name="image-alt" placeholder="A short description of the image." />
        </div>
        <div class="field">
            <label for="image-size">Image Size</label>
            <select name="image-size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
                <option value="third">One Third</option>
                <option value="half">One Half</option>
                <option value="fullwidth">Fullwidth</option>
                <option value="original">Original</option>
            </select>
        </div>
        <div class="field">
            <label for="image-placement">Image Placement</label>
            <select name="image-placement">
                <option value="left">Left</option>
                <option value="right">Right</option>
                <option value="center">Center</option>
                <option value="inline">Inline</option>
            </select>
        </div>
        <button class="insert">Insert</button>
    </div>
</div><!-- end #img-prompt -->

<div class="prompt-container" id="link-prompt">
    <div class="prompt">
        <button class="close" title="Close">
            <i class="fas fa-times"></i>
        </button>
        <div class="field">
            <label for="link-text">Link Text</label>
            <input type="text" name="link-text" placeholder="Link Text" />
        </div>
        <div class="field">
            <label for="link-url">Link URL</label>
            <input type="text" name="link-url" placeholder="https://example" />
        </div>
        <div class="flex">
            <button class="insert">Insert</button>
            <button class="unlink">Unlink</button>
        </div>
    </div>
</div><!-- end #link-prompt -->

<div class="prompt-container" id="video-prompt">
    <div class="prompt">
        <button class="close" title="Close">
            <i class="fas fa-times"></i>
        </button>
        <div class="field">
            <label for="video-url">Video URL</label>
            <input type="text" name="video-url" placeholder="Youtube or Vimeo embed link" />
        </div>
        <button class="insert">Insert</button>
    </div>
</div><!-- end #video-prompt -->
