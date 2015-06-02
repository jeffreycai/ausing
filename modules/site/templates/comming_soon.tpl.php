<div>
  <div class="row" style="text-align: center; background-color: #444; padding-top: 70px; position: relative;">
    <div class="col-xs-12">
      <img src="<?php echo uri('modules/site/assets/images/logo-single.jpg') ?>" style="border-radius: 15px; display: inline-block; width: 100px;" />
      <h1 style="color: #FFF; padding-bottom: 30px;"><?php echo $settings['sitename'] ?></h1>
    </div>
  </div>
</div>

<div class="container">
  <div class="row" style="text-align: center;">
    <div class="col-xs-12">
      <h3>网站建设中</h3>
      <p>请将您的邮箱告知我们，我们会在网站上线第一时间通知您</p>
    </div>
    <div class="col-xs-12">
      <form class="form-inline" action="<?php echo uri('coming-soon') ?>" method="POST">
        <?php echo Message::renderMessages(); ?>
        <div class="form-group">
          <label class="sr-only" for="exampleInputEmail3">电子邮箱地址</label>
          <input class="form-control" name="email" type="email" placeholder="您的电子邮箱" style="width: 200px; display: inline-block !important;" required />
          <button type="submit" class="btn btn-default" style="display: inline-block !important;">提交</button>
        </div>
      </form>
      <p style="margin-bottom: 40px;"></p>
    </div>
  </div>
</div>