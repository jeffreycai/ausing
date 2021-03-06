<div id="page-wrapper">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header"><?php i18n_echo(array(
        'en' => 'Deal',
        'zh' => '折扣',
      )); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array(
            'en' => 'Edit', 
            'zh' => '编辑'
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php echo uri('admin/deal/edit/' . $object->getId()) ?>">
  
<div class='form-group'>
  <label for='title'>title</label>
  <textarea class='form-control' rows='5' id='title' name='title'><?php echo ($object->isNew() ? (isset($_POST['title']) ? htmlentities($_POST['title']) : '') : htmlentities($object->getTitle())) ?></textarea>
</div>
  
<div class='form-group'>
  <label for='vendor'>vendor</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['vendor']) ? strip_tags($_POST['vendor']) : '') : $object->getVendor()))) ?>' type='text' class='form-control' id='vendor' name='vendor' />
</div>
  
<div class='form-group'>
  <label for='affiliate_url'>affiliate_url</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['affiliate_url']) ? strip_tags($_POST['affiliate_url']) : '') : $object->getAffiliateUrl()))) ?>' type='text' class='form-control' id='affiliate_url' name='affiliate_url' />
</div>
  
<div class='form-group'>
  <label for='original_url'>original_url</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['original_url']) ? strip_tags($_POST['original_url']) : '') : $object->getOriginalUrl()))) ?>' type='text' class='form-control' id='original_url' name='original_url' />
</div>
  
<div class='form-group' id='thumbnail'>
  <label>thumbnail</label>
  <textarea name='thumbnail' style='display: none;'></textarea>
  <div class='file-fields'></div>

</div>

<?php
  // get json string of prepopulated image links
  $prepopulate = $object->isNew() ? '' : $object->getThumbnail();
  if ($prepopulate != '') {
    $tokens = explode("\n", trim($prepopulate));
    $prepopulate = array();
    foreach ($tokens as $token) {
      $prepopulate[] = trim($token, "\n\r");
    }
  }
?>

<script>
  $(function(){
    var container = $('#thumbnail');

    // initial value to pop
    var initial_images = <?php echo $prepopulate == '' ? '""' : json_encode($prepopulate); ?>;
    if (initial_images != '') {
      for (var i in initial_images) {
        img = initial_images[i];
        var html = addImageRow(img, false);
        $('.file-fields', container).append(html);
      }
    } else {
      var html = addImageRow(false, true);
      $('.file-fields', container).append(html);
    }

    updateHiddenTextarea(container);
    // action when click select file button
    $(document).on('click', '#thumbnail .select', function(){
      var tr = $(this).parents('.file-field');
      $('input[type=file]', tr).click();
      $('.upload', tr).prop('disabled', false);
    });
    // action when file filed is changed (we do validation here)
    $(document).on('change', '#thumbnail input[type=file]', function(){
      var tr = $(this).parents('.file-field');
      var file = this.files[0];
      if (!file.type.match(/^image/)) {
        alert('<?php echo i18n(array('en' => 'Upload file needs to be an image file', 'zh' => '上传文件需为图片文件')) ?>');
      } else if (file.size > (2 * 1000 * 1000)) {
        alert('<?php echo i18n(array('en' => 'File size should be less than', 'zh' => '文件大小应小于')) . ' 2MB' ?>');
      } else {
        var reader = new FileReader();
        reader.onload = (function(e){
          $('.preview', tr).html('<img src="'+e.target.result+'" style="height:150px;" />');
        });
        reader.readAsDataURL(this.files[0]);
      }
    });
    // action when adding an new image row
    $(document).on('click', '#thumbnail .add', function(){
      var html = addImageRow(false, true);
      $('.file-fields', container).append(html);
    });
    // action when uploading image via ajax
    $(document).on('click', '#thumbnail .upload', function(){
      var tr = $(this).parents('.file-field');
      var file_field = $('input[type=file]', tr);
      var file = file_field[0].files[0];

      var formData = new FormData();
      formData.append('file', file, file.name);
      $('.btn', tr).prop('disabled', true);
      $('.upload i', tr).removeClass('fa-upload').addClass('fa-spin').addClass('fa-spinner');
      $.ajax({
        url: '<?php echo uri("modules/deal/controllers/backend/deal_form_field_thumbnail.php" ,false) ?>',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR) {
          if (typeof(data.error) !== 'undefined') {
            alert('<?php echo i18n(array('en' => 'Error: ', 'zh' => '错误: ')) ?>' + data.error);
          } else {
            tr.html(addImageRow(data.uri, false));;
            $('.remove',tr).data('uri', data.uri);
            updateHiddenTextarea(container);
          }
          $('.btn', tr).prop('disabled', false);
          $('.upload i', tr).removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-upload');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('<?php echo i18n(array('en' => 'ajax error: ', 'zh' => 'ajax失败')) ?>: ' + textStatus);
          $('.btn', tr).prop('disabled', false);
          $('.upload i', tr).removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-upload');
        }
      });
    });
    // action when removing an image
    $(document).on('click', '#thumbnail .remove', function(){
      var tr = $(this).parents('.file-field');
      if (typeof($(this).data('uri')) !== 'undefined') {
        var img = $(this).data('uri');
        $('.btn', tr).prop('disabled', true);
        $('.remove i', tr).addClass('fa-spin').addClass('fa-spinner').removeClass('fa-remove');
        // ajax to remove the image
        $.ajax({
          url: '<?php echo uri("modules/deal/controllers/backend/deal_form_field_thumbnail"."_remove.php" ,false) ?>?path=' + encodeURIComponent(img),
          type: 'POST',
          dataType: 'json',
          success: function(data, textStatus, jqXHR) {
            if (typeof(data.error) !== 'undefined') {
              alert('<?php echo i18n(array('en' => 'Error: ', 'zh' => '错误: ')) ?>' + data.error);
tr.html(addImageRow(false, true));
              updateHiddenTextarea(container);
            } else {
tr.html(addImageRow(false, true));
              updateHiddenTextarea(container);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('<?php echo i18n(array('en' => 'ajax error: ', 'zh' => 'ajax失败')) ?>: ' + textStatus);
            $('.btn', tr).prop('disabled', false);
            $('.remove i', tr).removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-remove');
            updateHiddenTextarea(container);  
          }
        });
      } else {

      }
    });

    // functions
    function addImageRow(img, isnew) {
      var img_html = img ? '<img src="/<?php echo get_sub_root() ?>'+img+'" style="height:150px;" />' : '<div style="height:150px;width:200px;background-color:#AAA;"></div>';
      var upload_button = isnew ? 
        '<button type="button" class="btn btn-default btn-sm upload" disabled><i class="fa fa-upload"></i></button>' :
        '<!-- <button type="button" class="btn btn-default btn-sm upload" disabled><i class="fa fa-upload"></i></button> -->';
      var select_button = isnew ?
        '<button type="button" class="btn btn-default btn-sm select"><i class="fa fa-file"></i></button>' :
        '<!-- <button type="button" class="btn btn-default btn-sm select"><i class="fa fa-file"></i></button> -->';
      var data_uri = isnew ? '' : 'data-uri="'+img+'"';
      return ('\n\
    <div class="file-field" style="margin-bottom:6px; position:relative;">\n\
      <div class="preview">'+img_html+'</div>\n\
      <div class="btn-group" style="position:absolute; bottom:5px; left:5px; " aria-label="...">\n\
        <input type="file" class="btn btn-default btn-sm" style="display:none;" />\n\
        '+select_button+'\n\
        '+upload_button+'\n\
        <button type="button" class="btn btn-default btn-sm remove" '+data_uri+'><i class="fa fa-remove"></i></button>\n\
      </div>\n\
    </div>');
    }

    function updateHiddenTextarea(container) {
      var html = '';
      $('.preview img', container).each(function(){
        var uri = $(this).attr('src');
        // remove subroot
        var subroot = '<?php echo get_sub_root() ?>';
        uri = uri.substr(subroot.length+1, uri.length-1);
        html = html + uri + "\n";
      });
      $('textarea', container).val(html);
    }
  });
</script>
  
<div class='form-group' id='images'>
  <label>images</label>
  <textarea name='images' style='display: none;'></textarea>
  <div class='file-fields' style='border: 1px solid #999; padding: 6px;'></div>
  <button style='margin-top:6px;' class='add btn btn-primary btn-sm' type='button'><?php echo i18n(array('en' => 'Add image', 'zh' => '添加图片')) ?></button>
</div>

<?php
  // get json string of prepopulated image links
  $prepopulate = $object->isNew() ? '' : $object->getImages();
  if ($prepopulate != '') {
    $tokens = explode("\n", trim($prepopulate));
    $prepopulate = array();
    foreach ($tokens as $token) {
      $prepopulate[] = trim($token, "\n\r");
    }
  }
?>

<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js'></script>

<script>
  $(function(){
    var container = $('#images');

    $('.file-fields', container).sortable({
      update: function(event, ui) {updateHiddenTextarea(container);}
    });

    // initial value to pop
    var initial_images = <?php echo $prepopulate == '' ? '""' : json_encode($prepopulate); ?>;
    if (initial_images != '') {
      for (var i in initial_images) {
        img = initial_images[i];
        var html = addImageRow(img, false);
        $('.file-fields', container).append(html);
      }
    } else {
      var html = addImageRow(false, true);
      $('.file-fields', container).append(html);
    }

    updateHiddenTextarea(container);
    // action when click select file button
    $(document).on('click', '#images .select', function(){
      var tr = $(this).parents('.file-field');
      $('input[type=file]', tr).click();
      $('.upload', tr).prop('disabled', false);
    });
    // action when file filed is changed (we do validation here)
    $(document).on('change', '#images input[type=file]', function(){
      var tr = $(this).parents('.file-field');
      var file = this.files[0];
      if (!file.type.match(/^image/)) {
        alert('<?php echo i18n(array('en' => 'Upload file needs to be an image file', 'zh' => '上传文件需为图片文件')) ?>');
      } else if (file.size > (2 * 1000 * 1000)) {
        alert('<?php echo i18n(array('en' => 'File size should be less than', 'zh' => '文件大小应小于')) . ' 2MB' ?>');
      } else {
        var reader = new FileReader();
        reader.onload = (function(e){
          $('.preview', tr).html('<img src="'+e.target.result+'" style="height:150px;" />');
        });
        reader.readAsDataURL(this.files[0]);
      }
    });
    // action when adding an new image row
    $(document).on('click', '#images .add', function(){
      var html = addImageRow(false, true);
      $('.file-fields', container).append(html);
    });
    // action when uploading image via ajax
    $(document).on('click', '#images .upload', function(){
      var tr = $(this).parents('.file-field');
      var file_field = $('input[type=file]', tr);
      var file = file_field[0].files[0];

      var formData = new FormData();
      formData.append('file', file, file.name);
      $('.btn', tr).prop('disabled', true);
      $('.upload i', tr).removeClass('fa-upload').addClass('fa-spin').addClass('fa-spinner');
      $.ajax({
        url: '<?php echo uri("modules/deal/controllers/backend/deal_form_field_images.php" ,false) ?>',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR) {
          if (typeof(data.error) !== 'undefined') {
            alert('<?php echo i18n(array('en' => 'Error: ', 'zh' => '错误: ')) ?>' + data.error);
          } else {
            tr.html(addImageRow(data.uri, false));;
            $('.remove',tr).data('uri', data.uri);
            updateHiddenTextarea(container);
          }
          $('.btn', tr).prop('disabled', false);
          $('.upload i', tr).removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-upload');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('<?php echo i18n(array('en' => 'ajax error: ', 'zh' => 'ajax失败')) ?>: ' + textStatus);
          $('.btn', tr).prop('disabled', false);
          $('.upload i', tr).removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-upload');
        }
      });
    });
    // action when removing an image
    $(document).on('click', '#images .remove', function(){
      var tr = $(this).parents('.file-field');
      if (typeof($(this).data('uri')) !== 'undefined') {
        var img = $(this).data('uri');
        $('.btn', tr).prop('disabled', true);
        $('.remove i', tr).addClass('fa-spin').addClass('fa-spinner').removeClass('fa-remove');
        // ajax to remove the image
        $.ajax({
          url: '<?php echo uri("modules/deal/controllers/backend/deal_form_field_images"."_remove.php" ,false) ?>?path=' + encodeURIComponent(img),
          type: 'POST',
          dataType: 'json',
          success: function(data, textStatus, jqXHR) {
            if (typeof(data.error) !== 'undefined') {
              alert('<?php echo i18n(array('en' => 'Error: ', 'zh' => '错误: ')) ?>' + data.error);
tr.fadeOut(function(){tr.remove();});
              updateHiddenTextarea(container);
            } else {
tr.fadeOut(function(){tr.remove();});
              updateHiddenTextarea(container);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('<?php echo i18n(array('en' => 'ajax error: ', 'zh' => 'ajax失败')) ?>: ' + textStatus);
            $('.btn', tr).prop('disabled', false);
            $('.remove i', tr).removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-remove');
            updateHiddenTextarea(container);  
          }
        });
      } else {
tr.fadeOut();
      }
    });

    // functions
    function addImageRow(img, isnew) {
      var img_html = img ? '<img src="/<?php echo get_sub_root() ?>'+img+'" style="height:150px;" />' : '<div style="height:150px;width:200px;background-color:#AAA;"></div>';
      var upload_button = isnew ? 
        '<button type="button" class="btn btn-default btn-sm upload" disabled><i class="fa fa-upload"></i></button>' :
        '<!-- <button type="button" class="btn btn-default btn-sm upload" disabled><i class="fa fa-upload"></i></button> -->';
      var select_button = isnew ?
        '<button type="button" class="btn btn-default btn-sm select"><i class="fa fa-file"></i></button>' :
        '<!-- <button type="button" class="btn btn-default btn-sm select"><i class="fa fa-file"></i></button> -->';
      var data_uri = isnew ? '' : 'data-uri="'+img+'"';
      return ('\n\
    <div class="file-field" style="margin-bottom:6px; position:relative;">\n\
      <div class="preview">'+img_html+'</div>\n\
      <div class="btn-group" style="position:absolute; bottom:5px; left:5px; " aria-label="...">\n\
        <input type="file" class="btn btn-default btn-sm" style="display:none;" />\n\
        '+select_button+'\n\
        '+upload_button+'\n\
        <button type="button" class="btn btn-default btn-sm remove" '+data_uri+'><i class="fa fa-remove"></i></button>\n\
      </div>\n\
    </div>');
    }

    function updateHiddenTextarea(container) {
      var html = '';
      $('.preview img', container).each(function(){
        var uri = $(this).attr('src');
        // remove subroot
        var subroot = '<?php echo get_sub_root() ?>';
        uri = uri.substr(subroot.length+1, uri.length-1);
        html = html + uri + "\n";
      });
      $('textarea', container).val(html);
    }
  });
</script>
  
<div class='form-group'>
  <label for='description'>description</label>
  <textarea class='form-control' rows='5' id='description' name='description'><?php echo ($object->isNew() ? (isset($_POST['description']) ? htmlentities($_POST['description']) : '') : htmlentities($object->getDescription())) ?></textarea>
</div>

<script type='text/javascript' src='/libraries/ckeditor/ckeditor.js'></script>
<script type='text/javascript'>CKEDITOR.replace('description',{
    customConfig: '<?php echo uri('modules/deal/assets/js/ckeditor.conf.js', false) ?>'
});</script>
<div class='form-group'>
  <label for='wechat_description'>wechat_description</label>
  <textarea class='form-control' rows='5' id='wechat_description' name='wechat_description'><?php echo ($object->isNew() ? (isset($_POST['wechat_description']) ? htmlentities($_POST['wechat_description']) : '') : htmlentities($object->getWechatDescription())) ?></textarea>
</div>
<script type='text/javascript'>CKEDITOR.replace('wechat_description',{
    customConfig: '<?php echo uri('modules/deal/assets/js/ckeditor.conf.js', false) ?>'
});</script>
<div class='form-group'>
  <label for='created_at'>created_at</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['created_at']) ? strip_tags($_POST['created_at']) : '') : $object->getCreatedAt()))) ?>' type='text' class='form-control' id='created_at' name='created_at' required />
</div>
  
<div class='form-group'>
  <label for='expired_at'>expired_at</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['expired_at']) ? strip_tags($_POST['expired_at']) : '') : $object->getExpiredAt()))) ?>' type='text' class='form-control' id='expired_at' name='expired_at' />
</div>
  
<div class='checkbox'>
  <label>
    <input type='checkbox' <?php echo ($object->isNew() ? (isset($_POST['published']) ? ($_POST['published'] ? 'checked="checked"' : '') : '') : ($object->getPublished() ? "checked='checked'" : "")) ?> id='published' name='published' value='1' /> published
  </label>
</div>
  
<div class='checkbox'>
  <label>
    <input type='checkbox' <?php echo ($object->isNew() ? (isset($_POST['valid']) ? ($_POST['valid'] ? 'checked="checked"' : '') : '') : ($object->getValid() ? "checked='checked'" : "")) ?> id='valid' name='valid' value='1' /> valid
  </label>
</div>

  <input type="submit" name="submit" value="<?php i18n_echo(array(
      'en' => 'Edit', 
      'zh' => '编辑'
  )) ?>" class="btn btn-default">
</form>
          
        </div>
      </div>
    </div>
  </div>
</div>

<?php if ($object->getVendor() == Groupon::VENDOR): ?>
<script type="text/javascript">
  jQuery(function($){
    $('label[for="affiliate_url"]').append('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo uri('admin/groupon/build-affiliate-url', false) ?>" id="update-affiliate-url"><i class="fa fa-cloud-download"></i></a>');
    $('#update-affiliate-url').on('click', function(event){
      event.preventDefault();
      
      $('i', this).removeClass('fa-cloud-download').addClass('fa-spin fa-spinner');
      $.get($(this).attr('href'), "url="+encodeURIComponent($('#original_url').val()), function(data){
        $('#update-affiliate-url i').removeClass('fa-spin fa-spinner').addClass('fa-cloud-download');
        if (data.status == 'success') {
          $('#affiliate_url').val(data.affiliate_url);
        } else {
          alert(data.error_msg);
        }
      }, 'json');
    });
  });
</script>
<?php endif; ?>