        <div class="col-md-3">
            <div class="alert alert-warning">
                <h4><?php echo $this->lang['mod']['label']['source']; ?></h4>
                <hr>
                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['pluginName']; ?></label>
                    <div class="form-text">
                        <?php if (isset($this->tplData['pluginConfig']['plugin_url']) && !fn_isEmpty($this->tplData['pluginConfig']['plugin_url'])) { ?>
                            <a href="<?php echo $this->tplData['pluginConfig']['plugin_url']; ?>" target="_blank">
                        <?php }
                        echo $this->tplData['pluginConfig']['name'];
                        if (isset($this->tplData['pluginConfig']['plugin_url']) && !fn_isEmpty($this->tplData['pluginConfig']['plugin_url'])) { ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['pluginClass']; ?></label>
                    <div class="form-text">
                        <?php echo $this->tplData['pluginConfig']['class']; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['pluginVer']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['pluginConfig']['version']; ?></div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['pluginAuthor']; ?></label>
                    <div class="form-text">
                        <?php if (isset($this->tplData['pluginConfig']['author_url']) && !fn_isEmpty($this->tplData['pluginConfig']['author_url'])) { ?>
                            <a href="<?php echo $this->tplData['pluginConfig']['author_url']; ?>" target="_blank">
                        <?php }
                        echo $this->tplData['pluginConfig']['author'];
                        if (isset($this->tplData['pluginConfig']['author_url']) && !fn_isEmpty($this->tplData['pluginConfig']['author_url'])) { ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['detail']; ?></label>
                    <p class="bg-content">
                        <?php if (isset($this->tplData['pluginConfig']['detail'])) {
                            echo $this->tplData['pluginConfig']['detail'];
                        } ?>
                    </p>
                </div>
            </div>
        </div>
