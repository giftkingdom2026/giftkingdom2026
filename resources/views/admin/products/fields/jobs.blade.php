<div class="row">

    <input type="hidden" name="fields" value="job_type,position">    

    <?php isset($data['post_data']) ? $metadata = $data['post_data']['metadata'] : $metadata = ''; ?>

    <div class="col-md-6">

        <div class="form-group mt-3">

            <div class="form-group">

                <label for="job_type" class="control-label mb-1">Job Type</label>

                <?php ( isset( $metadata['job_type'] ) ) ? $job_type = $metadata['job_type']  : $job_type = '' ;?>

                <input type="text" name="job_type" id="job_type" class="form-control" value="{{$job_type}}"/>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group mt-3">

            <div class="form-group">

                <label for="position" class="control-label mb-1">Position Type</label>

                <?php ( isset( $metadata['position'] ) ) ? $position = $metadata['position']  : $position = '' ;?>

                <input type="text" name="position" id="position" class="form-control" value="{{$position}}"/>

            </div>

        </div>

    </div>     

</div>




