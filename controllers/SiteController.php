<?php

namespace app\controllers;


use yii\web\Controller;
use app\models\Upload;
use yii\web\UploadedFile;
use Yii;



class SiteController extends Controller
{
    
    public function actionCategory()
    {
        $model = new Upload();

        if (Yii::$app->request->isPost) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            
            if ($model->upload()) {
                // файл загружен удачно
                return $this->render('index');
            }
        }

        return $this->render('category', ['model' => $model]);
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    

    
}
