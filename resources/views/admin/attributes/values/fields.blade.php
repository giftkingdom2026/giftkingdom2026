<?php $title = isset( $data['meta']['value_title'] )  ? $data['meta']['value_title'] : $data['value_title'];?>

<div class="form-group">
    <label for="name" class="control-label mb-3">Title</label>
    <input type="text" name="value_title" value="<?=$title?>" class="pagetitle form-control form-data" required>
</div>