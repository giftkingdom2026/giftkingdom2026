<?php $title = isset( $data['meta']['term_title'] )  ? $data['meta']['term_title'] : $data['term_title'];?>

<div class="form-group">
    <label for="name" class="control-label mb-3">Title</label>
    <input type="text" name="term_title" value="<?=$title?>" class="pagetitle form-control form-data" required>
</div>