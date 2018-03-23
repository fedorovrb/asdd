<?
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\Breadcrumbs;



$provider = new ActiveDataProvider([
    'query' => $data,
]);

// возвращает массив объектов Post
$posts = $provider->getModels();
   

foreach($posts as $key)
{ 
    echo '<h2><a href = "index.php?r=site/index&parent_id=' . $key["id"] . '">' . $key["name"] . '</a></h2><br><br>';
}