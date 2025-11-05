<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property string $name
 * @property int $uploaded_by
 * @property float $price
 * @property string $description
 * @property string $contact
 * @property string|null $image
 * @property int $created_at
 * @property int $updated_at
 */
class Sale extends ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'sale';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'description', 'contact'], 'required'],
            [['price'], 'number'],
            [['uploaded_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'contact', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    // ✅ Automatically fill created_at & updated_at
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function () {
                    return time(); // Unix timestamp
                },
            ],
        ];
    }

    public function upload()
    {
        if ($this->imageFile) {
            $fileName = uniqid() . '.' . $this->imageFile->extension;
            $filePath = 'uploads/' . $fileName;
            if ($this->imageFile->saveAs($filePath)) {
                $this->image = $filePath;
                return true;
            }
            return false;
        }
        return true; // No file uploaded but continue
    }

    //finds the name of the person who uploaded the image or file

    public function getUploader()
{
    return $this->hasOne(User::class, ['id' => 'uploaded_by']);
}
}
