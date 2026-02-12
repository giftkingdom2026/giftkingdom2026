<?php $title = isset( $data['meta']['category_title'] )  ? $data['meta']['category_title'] : $data['category_title'];?>

<div class="form-group">
    <label for="name" class="control-label mb-1">Title</label>
    <input type="text" name="category_title" value="<?=$title?>" class="pagetitle form-control form-data" required>
</div>

<div class="form-group mt-2">
    <label for="term_slug" class="control-label mb-1">Slug</label>
    <input type="text" name="categories_slug" value="{{$data['categories_slug']}}" class="form-control slug form-data">
</div>


<?php $metatitle = isset($data['meta']['metatitle']) ? $data['meta']['metatitle'] : '';?>

<div class="form-group my-3">

    <label for="metatitle" class="control-label mb-3">Meta Title</label>

    <input type="text" name="meta[metatitle]" id="metatitle" value="<?=$metatitle?>" class="form-control form-data">

</div>

<?php $metakeywords = isset($data['meta']['metakeywords']) ? $data['meta']['metakeywords'] : '';?>

<div class="form-group my-3">

    <label for="metakeywords" class="control-label mb-3">Meta Keywords</label>

    <input type="text" name="meta[metakeywords]" id="metakeywords" value="<?=$metakeywords?>" class="form-control form-data">

</div>

<?php $metadesc = isset($data['meta']['metadesc']) ? $data['meta']['metadesc'] : '';?>

<div class="form-group my-3">

    <label for="metadesc" class="control-label mb-3">Meta Description</label>

    <input type="text" name="meta[metadesc]" id="metadesc" value="<?=$metadesc?>" class="form-control form-data">

</div>