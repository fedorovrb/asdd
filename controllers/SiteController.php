<?php

namespace app\controllers;


use yii\web\Controller;
use app\models\Upload;
use yii\web\UploadedFile;
use yii\helpers\BaseJson;
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
                // читаем json из файла
                $file = file_get_contents($model->jsonFile->baseName . '.' . $model->jsonFile->extension, FILE_USE_INCLUDE_PATH);
                // преобразовуем в ассоциативный массив
                if(json_decode($file, true) == null)
                {
                   return $this->render('error');
                }
                else 
                {
                    $file = json_decode($file, true);
                    $model->db_insert($file);
                }
                
                $data = $model->db_selec(0);
                return $this->render('index', ['data' => $data]);

            }
        }

       return $this->render('category', ['model' => $model]);
    }
    
    public function actionIndex()
    {
        
            $model = new Upload();
            
            $parent = Yii::$app->request->get('parent_id');
            
            if($parent == null) $parent = 0;
            
            $data = $model->db_selec($parent);
    
            return $this->render('index', ['data' => $data]);

    }
    

    
}
