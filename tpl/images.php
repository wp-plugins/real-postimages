<?php
global $post;
$images = get_post_meta($post->ID, 'realpostimages_post_images', true);
?>

<div class="images">

  <?php if (is_array($images)) : ?>
    <?php foreach ($images as $id => $sizes) : ?>

      <?php $sizes_string = urlencode(json_encode($sizes)); ?>

      <label>
        <input type="checkbox" name="realpostimages_images[<?= $id; ?>]" value="<?= $sizes_string; ?>" class="id hidden" checked="checked" data-id="<?= $id; ?>" />
        <img src="<?= $sizes['thumbnail']['url']; ?>" />
      </label>

    <?php endforeach; ?>
  <?php endif; ?>

  <div class="clear"></div>

</div>

<button type="button" class="add button">
  <?= __('Add', 'realpostimages'); ?>
</button>