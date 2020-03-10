            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($posiRow['posi_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <div class="form-text"><?php echo $posiRow['posi_id']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Ad position'); ?></label>
                                <div class="form-text"><?php echo $posiRow['posi_name']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Status'); ?></label>
                                <div class="form-text">
                                    <?php $str_status = $posiRow['posi_status'];
                                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Ad count'); ?></label>
                                <div class="form-text"><?php echo $posiRow['posi_count']; ?></div>
                            </div>
                        <?php }

                        if (!empty($scriptConfig['name'])) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Ad script name'); ?></label>
                                <div class="form-text">
                                    <?php echo $scriptConfig['name']; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Note'); ?></label>
                                <div class="form-text">
                                    <?php echo $scriptConfig['note']; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
