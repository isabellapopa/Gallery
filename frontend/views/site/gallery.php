<?php
/**
 * Gallery list view
 *
 * @var Photo $photo
 * @var yii\data\DataProviderInterface $listDataProvider
 */


use common\models\Photo;
use yii\widgets\ListView;
$this->title = 'Gallery';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo ListView::widget([
    'dataProvider' => $listDataProvider,
    'itemView' => '_itemAlbum'
]); ?>



