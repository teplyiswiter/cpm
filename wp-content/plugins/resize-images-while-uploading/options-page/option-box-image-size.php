<p>
  <label for="large_size_w"><?php _e('Max Width') ?>:</label>
  <?php Form_Option('large_size_w'); ?>px
</p>

<p>
  <label for="large_size_h"><?php _e('Max Height') ?>:</label>
  <?php Form_Option('large_size_h') ?>px
</p>

<p><a href="<?php Echo Admin_Url('options-media.php') ?>"><?php Echo $this->t('You can change these options on the media settings page.') ?></a></p>
