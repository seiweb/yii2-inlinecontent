<?php
$this->title = $this->title == '' ? $pageModel->title : $this->title;
?>

<?php

if (isset($this->params['breadcrumbs']))
    $first = array_pop($this->params['breadcrumbs']);

foreach ($parents as $parent) {
    $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/' . $parent->full_slug]];
}
if (isset($first)) {
    $this->params['breadcrumbs'][] = ['label' => $pageModel->title, 'url' => ['/' . $pageModel->full_slug]];
    array_push($this->params['breadcrumbs'], $first);
} else {
    $this->params['breadcrumbs'][] = ['label' => $pageModel->title];
}
?>

<?php foreach ($content['content'] as $item) {
    echo $item;
}

foreach ($content as $k => $item) {
    if ($k == 'content') continue;

    foreach ($item as $cnt) {
        $this->beginBlock($k);
        echo $cnt;
        $this->endBlock();
    }
}