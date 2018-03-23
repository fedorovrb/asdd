<?
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{
    
    public $jsonFile;

    public function rules()
    {
        return [
            [['jsonFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'json', 'checkExtensionByMimeType' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->jsonFile->saveAs($this->jsonFile->baseName . '.' . $this->jsonFile->extension);
            return true;
        } else {
            return false;
        }
    }
}