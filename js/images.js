jQuery(function($){

  var frame,
      metaBox    = $('#realpostimages_post_images'),
      button_add = metaBox.find('.add'),
      button_del = metaBox.find('.delete'),
      images     = metaBox.find('.images'),
      id_inputs  = metaBox.find('.id');

  button_add.on('click', function(event) {

    event.preventDefault();

    if (frame) {
      frame.open();
      return;
    }

    frame = wp.media.frames.frame = wp.media({
      title: wp.media.view.l10n.createGalleryTitle,
      // button: { text: $(this).data('uploader_button_text') },
      library : { type : 'image' },
      multiple: true
    });

    frame.on('open', function() {

      var selection = frame.state().get('selection');

      // Выделить выбранные картинки
      if (id_inputs.length) {
        id_inputs.each(function() {
          attachment = wp.media.attachment($(this).attr('data-id'));
          attachment.fetch();
          selection.add(attachment ? [ attachment ] : []);
        });
      }

    });

    frame.on('select', function() {

      var selection = frame.state().get('selection');

      // Всавить ID выбранных картинок в дополнительное поле
      var ids = selection.map(function(attachment) {
        attachment = attachment.toJSON();
        return attachment.id;
      }).join();
      if (ids.charAt(0) === ',') {
        ids_inputs.val(ids.substring(1));
      }

      // Вставить миниатюры выбранных картинок в дополнительную область
      var attachment_thumbs = selection.map(function(attachment) {
        attachment = attachment.toJSON();
        if (attachment.id != '') {
          return '<label><input type="checkbox" name="realpostimages_images[' + attachment.id + ']" value="' + encodeURIComponent(JSON.stringify(attachment.sizes)) + '" class="hidden" checked="checked" data-id="' + attachment.id + '" /><img src="' + attachment.sizes.thumbnail.url + '" /></label>';
        }
      }).join(' ');
      images.html(attachment_thumbs).append('<div class="clear"></div>');

    });

    frame.open();

  });

});