    <div class="alert alert-warning mt-3">
        <p class="lead"><?php echo $lang->get('Info from SSO'); ?></p>
        <hr>
        <div class="form-group">
            <label><?php echo $lang->get('ID'); ?></label>
            <div class="form-text"><?php echo $userRow['user_id']; ?></div>
        </div>
        <div class="form-group">
            <label><?php echo $lang->get('Username'); ?></label>
            <div class="form-text"><?php echo $userRow['user_name']; ?></div>
        </div>
        <div class="form-group">
            <label><?php echo $lang->get('Email'); ?></label>
            <div class="form-text"><?php echo $userRow['user_mail']; ?></div>
        </div>
        <div class="form-group">
            <label><?php echo $lang->get('Nickname'); ?></label>
            <div class="form-text"><?php echo $userRow['user_nick']; ?></div>
        </div>
    </div>
