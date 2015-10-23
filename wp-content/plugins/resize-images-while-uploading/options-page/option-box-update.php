<h4><?php Echo $this->t('Your Account') ?></h4>
<p>
  <label for="update_username"><?php _e('Username') ?>:</label>
  <input type="text" id="update_username" value="<?php Echo $this->get_option('update_username') ?>" class="disabled" disabled="disabled">
</p>

<p>
  <label for="update_password"><?php _e('Password') ?>:</label>
  <input type="password" id="update_password" value="<?php Echo $this->get_option('update_password') ?>" class="disabled" disabled="disabled">
</p>

<p class="pro-notice"><?php Echo $this->Pro_Notice() ?></p>