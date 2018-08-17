                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbHost']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_HOST; ?>" name="db_host" id="db_host" data-validate class="form-control">
                    <small class="form-text" id="msg_db_host"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbName']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_NAME; ?>" name="db_name" id="db_name" data-validate class="form-control">
                    <small class="form-text" id="msg_db_name"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbPort']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_PORT; ?>" name="db_port" id="db_port" data-validate class="form-control">
                    <small class="form-text" id="msg_db_port"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbUser']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_USER; ?>" name="db_user" id="db_user" data-validate class="form-control">
                    <small class="form-text" id="msg_db_user"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbPass']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_PASS; ?>" name="db_pass" id="db_pass" data-validate class="form-control">
                    <small class="form-text" id="msg_db_pass"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbCharset']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_CHARSET; ?>" name="db_charset" id="db_charset" data-validate class="form-control">
                    <small class="form-text" id="msg_db_charset"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['dbtable']; ?> <span class="text-danger">*</span></label>
                    <input type="text" value="<?php echo BG_DB_TABLE; ?>" name="db_table" id="db_table" data-validate class="form-control">
                    <small class="form-text" id="msg_db_table"></small>
                </div>

                <script type="text/javascript">
                var opts_validator_form = {
                    db_host: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060204']; ?>", too_long: "<?php echo $this->lang['rcode']['x060205']; ?>" }
                    },
                    db_name: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060206']; ?>", too_long: "<?php echo $this->lang['rcode']['x060207']; ?>" }
                    },
                    db_port: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060208']; ?>", too_long: "<?php echo $this->lang['rcode']['x060209']; ?>" }
                    },
                    db_user: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060210']; ?>", too_long: "<?php echo $this->lang['rcode']['x060211']; ?>" }
                    },
                    db_pass: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060212']; ?>", too_long: "<?php echo $this->lang['rcode']['x060213']; ?>" }
                    },
                    db_charset: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060214']; ?>", too_long: "<?php echo $this->lang['rcode']['x060215']; ?>" }
                    },
                    db_table: {
                        len: { min: 1, max: 900 },
                        validate: { type: "str", format: "text" },
                        msg: { too_short: "<?php echo $this->lang['rcode']['x060216']; ?>", too_long: "<?php echo $this->lang['rcode']['x060217']; ?>" }
                    }
                };
                </script>