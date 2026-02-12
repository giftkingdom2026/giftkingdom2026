<?php $title = isset( $data['meta']['attribute_title'] )  ? $data['meta']['attribute_title'] : $data['attribute_title'];?>

<div class="form-group">
    <label for="name" class="control-label mb-3">Title</label>
    <input type="text" name="attribute_title" value="<?=$title?>" class="pagetitle form-control form-data" required>
</div>