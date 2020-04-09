<?php

class StatisticController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if ($this->isAPIRequest()) {
            $this->sendAjaxResponse($model);
        }

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Statistic::model()->findByPk($id);
        if ($model === null) {
            if ($this->isAPIRequest()) {
                $this->sendAjaxResponse(new NotFoundException());
            }
            {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        return $model;
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Statistic('search');
        $model->unsetAttributes();  // clear any default values
        $model->attributes = $_GET;

        if ($this->isAPIRequest()) {
            $this->sendAjaxResponse($model->search());
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'statistic-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
