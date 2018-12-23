<?php
$this->title = $info['headtitle'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $info['keywords']]);
$this->registerMetaTag(['name' => 'description', 'content' => $info['description']], 'description');
?>
<div class="gbox">
    <div class="wraper2">
        <div style="padding:20px;"> 
            <?= $info['content']['content'] ?>
        </div>
    </div>
</div>