    <div class="alert alert-warning mb-3">
        <h5><?php echo $lang->get('Ad position'); ?></h5>

        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang->get('ID'); ?></label>
                    <div class="form-text">
                        <?php echo $posiRow['posi_id']; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang->get('Name'); ?></label>
                    <div class="form-text">
                        <?php echo $posiRow['posi_name']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
