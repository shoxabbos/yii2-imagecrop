<?php
/**
 * Created by PhpStorm.
 * User: shoxabbos
 * Date: 8/3/17
 * Time: 14:23
 */

namespace app\widgets\crop;

use app\components\helpers\SimpleImage;
use yii\base\Action;
use yii\base\DynamicModel;

class CropAction extends Action {

    public $width = 100;
    public $height = 100;

    public function run() {
        $model = new DynamicModel(['x', 'y', 'width', 'height', 'rotate', 'scaleX', 'scaleY', 'path', 'widthTo', 'widthTo']);
        $model->addRule(['x', 'y', 'width', 'height', 'rotate', 'scaleX', 'scaleY'], 'integer')
            ->addRule(['x', 'y', 'width', 'height', 'path'], 'required');

        if ($model->load(\Yii::$app->request->post()) && is_file($model->path)) {
            /**
             * @var $img SimpleImage
             */
            $img = \Yii::$app->image;
            $img->load($model->path)
                ->crop($model->x, $model->y, $model->x + $model->width, $model->y + $model->height)
                ->resize($this->width, $this->height)
                ->save($model->path);
        }

        \Yii::$app->response->redirect(\Yii::$app->request->referrer);
    }

}