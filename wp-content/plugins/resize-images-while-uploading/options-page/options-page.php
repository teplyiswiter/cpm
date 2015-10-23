<div class="wrap">
  <?php Screen_Icon('options-general') ?>
  <h2><?php Echo $this->t('Auto Image Resizer') ?></h2>

  <?php If ($this->saved_options) : ?>
  <div class="updated fade"><p><strong><?php _e('Settings saved.') ?></strong></p></div>
  <?php EndIf; ?>

  <form method="post" action="#" enctype="multipart/form-data">
  <div class="metabox-holder">

    <div class="postbox-container left">
      <?php ForEach ($this->arr_option_box['main'] AS $box) : ?>
        <div class="postbox <?php Echo $box['state'] ?>">
          <h3 class="hndle" title="<?php _e('Click to toggle') ?>"><span><?php Echo $box['title'] ?></span></h3>
          <div class="inside"><?php Include $box['file'] ?></div>
        </div>
      <?php EndForEach ?>
    </div>

    <div class="postbox-container right">
      <?php ForEach ($this->arr_option_box['side'] AS $box) : ?>
        <div class="postbox <?php Echo $box['state'] ?>">
          <h3 class="hndle" title="<?php _e('Click to toggle') ?>"><span><?php Echo $box['title'] ?></span></h3>
          <div class="inside"><?php Include $box['file'] ?></div>
        </div>
      <?php EndForEach ?>
    </div>

  </div>

  <p class="submit">
    <input type="submit" class="button-primary disabled" value="<?php _e('Save Changes') ?>" <?php Disabled(True) ?> >
    <input type="reset" value="<?php _e('Reset') ?>" <?php Disabled(True) ?> >
  </p>

  </form>
</div>