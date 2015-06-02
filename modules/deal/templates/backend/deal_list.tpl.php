

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Deal','zh' => '折扣',)); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array('en' => 'List', 'zh' => '列表')) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr role="row">
                <th>id</th>
                <th>vendor</th>
                <th>original_id</th>
                <th>title</th>
                <th>affiliate_url</th>
                <th>original_url</th>
                <th>thumbnail</th>
                <th>images</th>
                <th>description</th>
                <th>wechat_description</th>
                <th>created_at</th>
                <th>expired_at</th>
                <th>published</th>
                <th>valid</th>
                <th>Actions</th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($objects as $object): ?>
    <tr>
            <td><?php echo $object->getId() ?></td>
            <td><?php echo $object->getVendor() ?></td>
            <td><?php echo $object->getOriginalId() ?></td>
            <td><?php echo $object->getTitle() ?></td>
            <td><?php echo $object->getAffiliateUrl() ?></td>
            <td><?php echo $object->getOriginalUrl() ?></td>
            <td><?php echo $object->getThumbnail() ?></td>
            <td><?php echo $object->getImages() ?></td>
            <td><?php echo $object->getDescription() ?></td>
            <td><?php echo $object->getWechatDescription() ?></td>
            <td><?php echo $object->getCreatedAt() ?></td>
            <td><?php echo $object->getExpiredAt() ?></td>
            <td><?php echo $object->getPublished() ?></td>
            <td><?php echo $object->getValid() ?></td>
            <td>
        <div class="btn-group">
          <a class="btn btn-default btn-sm" href="<?php echo uri('admin/deal/edit/' . $object->getId()); ?>"><i class="fa fa-edit"></i></a>
          <a onclick="return confirm('<?php echo i18n(array('en' => 'Are you sure to delete this record ?', 'zh' => '你确定删除这条记录吗 ?')); ?>');" class="btn btn-default btn-sm" href="<?php echo uri('admin/deal/delete/' . $object->getId(), false); ?>"><i class="fa fa-remove"></i></a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-sm-12" style="text-align: right;">
  <?php i18n_echo(array(
      'en' => 'Showing ' . $start_entry . ' to ' . $end_entry . ' of ' . $total . ' entries', 
      'zh' => '显示' . $start_entry . '到' . $end_entry . '条记录，共' . $total . '条记录',
  )); ?>
  </div>
  <div class="col-sm-12" style="text-align: right;">
  <?php echo $pager; ?>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
</div>