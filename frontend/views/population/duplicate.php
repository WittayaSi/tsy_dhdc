<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'ประเภทการอยู่อาศัยที่ซ้ำซ้อน';
    $this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
	$this->params['breadcrumbs'][] = 'ประเภทการอยู่อาศัยที่ซ้ำซ้อน';
?>
<?php 
$gridColumn = [
    //['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'เลขประชาชน',
        'label' => 'เลขประชาชน'
    ],
    [
        'attribute' => 'ชื่อ',
        'label' => 'ชื่อ',
    ],
    [
        'attribute' => 'สกุล',
        'label' => 'สกุล'
    ],
    [
        'attribute' => 'ประเภทพักอาศัย',
        'label' => 'ประเภทพักอาศัย'
    ],
    [
        'attribute' => 'เลขประจำตัวฐานHISของท่าน',
        'label' => 'เลขประจำตัว'
    ],
    [
        'attribute' => 'วันเกิด',
        'label' => 'วันเกิด'
    ],
    [
        'attribute' => 'รหัสหน่วยบริการที่ซ้ำซ้อนเป้าหมายคนไทย',
        'label' => 'รหัสหน่วยบริการ'
    ]
];
?>

<?php $header = '<i class="glyphicon glyphicon-th-list"></i> ประชากรแยกตามประเภทการอยู่อาศัย '?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'pjax' => true,
    'pjaxSettings' => [
        //'neverTimeout' => true,
        'options' => [
            'enablePushState' => false,
        ],
    ],
    'responsive' => true,
    'hover' => true,
    'panel' => [
        'before' => '',
    //'after'=>''
    ],
    'columns' => $gridColumn,
    'containerOptions' => ['style'=>'overflow: auto;'],
    'panel' => [
        'type' => GridView::TYPE_INFO,
        'heading' => $header,
    ],
]); 
?>

