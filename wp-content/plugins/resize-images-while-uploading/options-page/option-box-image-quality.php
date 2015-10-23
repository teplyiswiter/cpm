<p>
  <label for="jpeg_quality"><?php Echo $this->t('JPEG Quality:') ?></label>
  <input type="text" id="jpeg_quality" value="<?php Echo $this->get_option('jpeg_quality') ?>" class="short disabled" <?php Disabled(True) ?> >
  <div class="hint">(<?php Echo $this->t('Ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file).') ?>)</div>
</p>

<p>
  <label for="png_compression"><?php Echo $this->t('PNG Compression:') ?></label>
  <input type="text" id="png_compression" value="<?php Echo $this->get_option('png_compression') ?>" class="short disabled" disabled="disabled">
  <div class="hint">(<?php Echo $this->t('Compression level: from 0 (no compression) to 9.') ?>)</div>
</p>

<p class="pro-notice"><?php Echo $this->Pro_Notice() ?></p>