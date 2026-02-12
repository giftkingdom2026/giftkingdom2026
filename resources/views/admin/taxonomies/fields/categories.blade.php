<input type="hidden" class="form-data" name="fields" value="description">    


<div class="form-group my-3">

    <div class="form-group">

        <label for="description" class="control-label mb-1">Description</label>

        <?php

        isset($data['meta']['description']) ? $description = $data['meta']['description'] : $description = ''; ?>

        <div class="quilleditor form-data" name="description" id="description" height="150" menu="false"><?=$description?></div>

    </div>

</div>

