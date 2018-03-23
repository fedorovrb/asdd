<?
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class Upload extends Model
{
    
    public $jsonFile;

    // проверка файла на валидность
    public function rules()
    {
        return [
            [['jsonFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'json', 'checkExtensionByMimeType' => false],
        ];
    }
    
    //сохраняет файл
    public function upload()
    {
        if ($this->validate()) {
            $this->jsonFile->saveAs($this->jsonFile->baseName . '.' . $this->jsonFile->extension);
            return true;
        } else {
            return false;
        }
    }
    
    // добавляет данные json в БД
    public function db_insert($file)
    {
        // удаляем старую таблицу
        Yii::$app->db->createCommand('DROP TABLE categories')->execute();
        
        // создаем новую
        Yii::$app->db->createCommand('CREATE TABLE `categories` (
                                     `id` int(11) NOT NULL,
                                     `name` varchar(50) NOT NULL,
                                     `parent_id` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;')->execute();
        Yii::$app->db->createCommand('ALTER TABLE `categories`
                                    ADD PRIMARY KEY (`id`)')->execute();
        Yii::$app->db->createCommand('ALTER TABLE `categories`
                                    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1')->execute();

        // заполняем таблицу данными
       foreach($file as $key)
       {
            $name = $key["name"];
            $parent_id = $key["parent_id"];
    
           Yii::$app->db->createCommand()->insert('categories', [
                    'name' => $name,
                    'parent_id' => $parent_id,
           ])->execute();
        }
    } 
    
    // выводит список категорий
    public function db_selec($parent)
    {
        return $rows = (new \yii\db\Query())
        ->from('categories')
        ->where(['parent_id' => $parent]);
    }

}