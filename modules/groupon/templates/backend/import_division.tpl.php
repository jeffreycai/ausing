

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Groupon','zh' => 'Groupon',)); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <form id="add-by-url" action="<?php echo uri('admin/groupon/deal-import', false) ?>" method="post" class="form-inline">
        <label>Groupon page url</label>
        <input class="form-control" type="text" name="url" />
        <input type="submit" value="Import" class="btn btn-default btn-sm import" />
      
        <script type="text/javascript">
          $("#add-by-url input[type=submit]").click(function(event){
            event.preventDefault();

            $(this).val('Importing ...').addClass('disabled');

            var form = $('#add-by-url');
            var action = form.attr('action');
            var url = $('input[name=url]', form).val();
            $.post(action, "url="+encodeURIComponent(url), function(data){
              if (data == 'success') {
                $("#add-by-url input[name=url]").val('');
              } else {
                alert(data);
              }
              $("#add-by-url input[type=submit]").val('Import').removeClass('disabled');
            });
          });
        </script>
      </form>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <ul class="nav nav-tabs">
        <li role="presentation"<?php echo_link_active_class('/import$/', get_cur_page_url()) ?>><a href="<?php echo uri('admin/groupon/import') ?>">Homepage</a></li>
        <li role="presentation"<?php echo_link_active_class('/sydney\-premium/', get_cur_page_url()) ?>><a href="<?php echo uri('admin/groupon/import/division/sydney-premium') ?>">API - sydney-premium</a></li>
        <li role="presentation"<?php echo_link_active_class('/national\-deal/', get_cur_page_url()) ?>><a href="<?php echo uri('admin/groupon/import/division/national-deal') ?>">API - national-deal</a></li>
      </ul>
    </div>
  </div>
          
  <div class="row" style="margin-top: 15px;">
        <?php echo Message::renderMessages(); ?>
          
          <?php $i = 0; ?>
          <?php foreach ($deals as $deal):// _debug($deal);?>
          <div class="col-xs-6 col-md-4 col-lg-3" style="padding-bottom: 15px;" id="deal-<?php echo $i ?>">
            <div style="position: relative; margin: 0 0 10px 0;">
              <img src="<?php echo $deal->mediumImageUrl ?>" class="img-responsive" />
              <div style="background-color: rgba(0,0,0,0.5); color: #FFF; position: absolute; bottom: 0; left: 0; padding: 4px;">
                <?php echo $deal->title; ?>
              </div>
            </div>

            <form action="<?php echo uri('admin/groupon/deal-import', false) ?>" method="post">
              <input type="hidden" name="url" value="<?php echo $deal->url ?>" />
              <input type="submit" value="Import" class="btn btn-default btn-sm import" />
            </form>
            
          </div>
    
    
      <script type="text/javascript">
          $("#deal-<?php echo $i ?>").click(function(){

            var form = $('form', this);
            var action = form.attr('action');
            var url = $('input[name=url]', form).val();
            var id = $(this).attr('id');

            $.post(action, "url=<?php echo urlencode($deal->url) ?>", function(data){
              if (data == 'success') {
                $("#"+id).fadeOut();
              } else {
                alert(data);
              }
            });
        
            return false;
          });
      </script>
    
    
          <?php $i++; endforeach; ?>
          

  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <?php echo $pagination; ?>
    </div>
  </div>
</div>