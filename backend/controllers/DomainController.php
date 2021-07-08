<?php

namespace backend\controllers;

use backend\components\Phois\Whois\Whois;
use common\components\MegaindexParser;
use common\models\Setting;
use common\models\Tools;
use Curl\Curl;
use Yii;
use common\models\Domain;
use common\models\DomainSearch;
use yii\caching\TagDependency;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DomainController implements the CRUD actions for Domain model.
 */
class DomainController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DomainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $parserSettings = Setting::find()->where(['like', 'option', 'parser.'])->all();
        $parserSettings = Setting::prepareSettingsForForms($parserSettings);

        if (Yii::$app->request->post() && isset(Yii::$app->request->post()['Setting'])) {
            $this->updateSettings();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parserSettings' => $parserSettings
        ]);
    }

    public function updateSettings()
    {
        foreach (Yii::$app->request->post()['Setting'] as $item) {
            $setting = Setting::findOne($item['id']);
            if (is_array($item['value'])) {
                $item['value'] = json_encode($item['value'], JSON_UNESCAPED_UNICODE);
            }
            $setting->value = $item['value'];
            $setting->save();

            if (isset($post['cache_key'])) {
                Yii::$app->cache->delete($post['cache_key']);
            }
            if (isset($post['cache_dependency'])) {
                TagDependency::invalidate(Yii::$app->cache, $post['cache_dependency']);
            }
        }

        $parserSettings = Setting::find()->where(['like', 'option', 'parser.'])->all();
        $parserSettings = Setting::prepareSettingsForForms($parserSettings);

        return $this->renderPartial('_settingsForm', ['settings' => $parserSettings]);
    }

    /**
     * Displays a single Domain model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Tools::removeTimeout();
        $model = new Domain();

        if ($model->load(Yii::$app->request->post())) {
            $domains = Yii::$app->request->post('Domain');
            $categoryId = $domains['category_id'];
            $domainsList = $domains['list'];
            $domainsList = explode("\n", $domainsList);

            foreach ($domainsList as $domain) {
                if (!empty($domain)) {
                    $model = new Domain();
                    $model->domain = trim($domain);
                    $model->category_id = $categoryId;
                    $model->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Домены добавлены');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Domain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Domain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Domain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Domain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Domain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMegaindex()
    {
        Tools::removeTimeout();

        session_write_close();
        if (isset($_POST['ids'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii megaindex/start 0 ' . implode(',', $_POST['ids']));
        } elseif (isset($_POST['categoryId'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii megaindex/start ' . $_POST['categoryId']);
        } else {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii megaindex/start');
        }

        return $result;
    }

    public function actionLinkpad()
    {
        Tools::removeTimeout();

        session_write_close();
        if (isset($_POST['ids'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii linkpad/start 0 ' . implode(',', $_POST['ids']));
        } elseif (isset($_POST['categoryId'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii linkpad/start ' . $_POST['categoryId']);
        } else {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii linkpad/start');
        }

        return (boolean)$result;
    }

    public function actionAvailable()
    {
        Tools::removeTimeout();
        session_write_close();

        if (isset($_POST['ids'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii available/start 0 ' . implode(',', $_POST['ids']));
        } elseif (isset($_POST['categoryId'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii available/start ' . $_POST['categoryId']);
        } else {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii available/start');
        }

        return (boolean)$result;
    }

    public function actionYandexSqi()
    {
        Tools::removeTimeout();
        session_write_close();

        if (isset($_POST['ids'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii yandex-sqi/start 0 ' . implode(',', $_POST['ids']));
        } elseif (isset($_POST['categoryId'])) {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii yandex-sqi/start ' . $_POST['categoryId']);
        } else {
            $result = shell_exec(dirname(dirname(__DIR__)) . '/yii yandex-sqi/start');
        }

        return (boolean)$result;
    }

    public function actionDeleteSelected()
    {
        if (!isset($_POST)) {
            return false;
        }

        $ids = $_POST['ids'];
        foreach ($ids as $id) {
            Domain::findOne(['id' => $id])->delete();
        }

        return true;
    }

    public function actionDeleteNotAvailableDomains()
    {
        if (!isset($_POST)) {
            return false;
        }

        $domains = Domain::find()->where(['is_available' => Domain::STATUS_NOT_AVAILABLE])->all();
        foreach ($domains as $domain) {
            $domain->delete();
        }

        return true;
    }

    public function actionDeleteNotAvailableDomainsFromCategory()
    {
        if (!isset($_POST['categoryId'])) {
            return false;
        }

        $domains = Domain::find()->where(['category_id' => $_POST['categoryId']])->andWhere(['is_available' => Domain::STATUS_NOT_AVAILABLE])->all();
        foreach ($domains as $domain) {
            $domain->delete();
        }

        return true;
    }

    public function actionDeleteAll()
    {
        if (!isset($_POST)) {
            return false;
        }

        Domain::deleteAll();
    }

    public function actionChangeCategory()
    {
        if (!isset($_POST['ids'])) {
            return false;
        }

        $data = [];
        foreach ($_POST['data'] as $item) {
            $data[$item['name']] = $item['value'];
        }

        if (!isset($data['categoryId'])) {
            return false;
        }

        $domains = Domain::find()->where(['id' => $_POST['ids']])->all();
        foreach ($domains as $domain) {
            $domain->category_id = $data['categoryId'];
            $domain->save();
        }

        return true;
    }

    public function actionMegaindexForce()
    {
        Tools::removeTimeout();
        session_write_close();

        $domains = Domain::find()->where(['is_available' => Domain::STATUS_AVAILABLE])->joinWith('megaindex')->andWhere(['megaindex.is_completed' => 0])->asArray()->all();
        if (!$domains) {
            die('Нет непроверенных доменов');
        }

        $parser = new MegaindexParser();
        $parser->setDomains($domains);
        $parser->parser();
    }
}
