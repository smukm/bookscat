<?php

declare(strict_types=1);

namespace modules\books\controllers;

use modules\books\entities\AuthorSearch;
use modules\books\forms\AuthorForm;
use modules\books\services\AuthorsService;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class AuthorController extends Controller
{

    protected AuthorsService $authorsService;

    public function __construct(
        $id,
        $module,
        AuthorsService $authorsService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->authorsService = $authorsService;
    }

    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'create' => ['GET'],
                        'edit' => ['GET'],
                        'store' => ['POST'],
                        'update' => ['PUT'],
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'store', 'edit', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'author' => $this->authorsService->findAuthor($id),
        ]);
    }


    public function actionCreate(): string
    {
        $authorForm = new AuthorForm();

        return $this->render('create', [
            'authorForm' => $authorForm,
        ]);
    }

    public function actionStore(): Response|string
    {
        $authorForm = new AuthorForm();

        try {
            if($authorForm->load($this->request->post()) && $authorForm->validate()) {

                $author = $this->authorsService->createAuthor($authorForm);

                return $this->redirect(['view', 'id' => $author->id]);
            }

        } catch(Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->render('create', [
            'authorForm' => $authorForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionEdit(int $id): string
    {
        $author = $this->authorsService->findAuthor($id);

        $authorForm = new AuthorForm();
        $authorForm->setAttributes($author->attributes);

        return $this->render('update', [
            'author' => $author,
            'authorForm' => $authorForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $authorForm = new AuthorForm();

        try {
            if($authorForm->load($this->request->post()) && $authorForm->validate()) {

                $author = $this->authorsService->editAuthor($authorForm, $id);

                return $this->redirect(['view', 'id' => $author->id]);
            }

        } catch(Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->render('update', [
            'authorForm' => $authorForm,
            'author' => $this->authorsService->findAuthor($id)
        ]);
    }

    public function actionDelete(int $id): Response
    {
        try {
            $this->authorsService->deleteAuthor($id);
        } catch (Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(['index']);
    }

}
