<?php

namespace modules\books\controllers;

use modules\books\entities\BookSearch;
use modules\books\forms\BookForm;
use modules\books\forms\SubscribeForm;
use modules\books\services\AuthorsService;
use modules\books\services\BooksService;
use modules\books\services\SubscribeService;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class BookController extends Controller
{

    protected BooksService $booksService;

    public function __construct(
        $id,
        $module,
        BooksService $booksService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->booksService = $booksService;
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
                        'show-modal' => ['GET'],
                        'subscribe' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view',],
                            'allow' => true,
                            'roles' => ['@', '?'],
                        ],
                        [
                            'actions' => ['create', 'store', 'edit', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        [
                            'actions' => ['show-modal', 'subscribe',],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new BookSearch();
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
            'book' => $this->booksService->findBook($id),
        ]);
    }

    public function actionCreate(): string
    {
        $bookForm = new BookForm();

        return $this->render('create', [
            'bookForm' => $bookForm,
        ]);
    }

    public function actionStore(): Response|string
    {
        $bookForm = new BookForm();
        $bookForm->isNewRecord = true;
        try {
            if($bookForm->load($this->request->post()) && $bookForm->validate()) {

                if (!$bookForm->upload()) {
                    Yii::$app->session->addFlash('error', 'Can`t upload a photo');
                }

                $book = $this->booksService->createBook($bookForm);

                return $this->redirect(['view', 'id' => $book->id]);
            }

        } catch(Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->render('create', [
            'bookForm' => $bookForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionEdit(int $id): string
    {
        $book = $this->booksService->findBook($id);

        $bookForm = new BookForm();
        $bookForm->setAttributes($book->attributes);

        return $this->render('update', [
            'book' => $book,
            'bookForm' => $bookForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $bookForm = new BookForm();

        try {
            if($bookForm->load($this->request->post()) && $bookForm->validate()) {

                if (!$bookForm->upload()) {
                    Yii::$app->session->addFlash('error', 'Can`t upload a photo');
                }

                $book = $this->booksService->editBook($bookForm, $id);

                return $this->redirect(['view', 'id' => $book->id]);
            }

        } catch(Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->render('update', [
            'bookForm' => $bookForm,
            'book' => $this->booksService->findBook($id)
        ]);
    }

    public function actionDelete(int $id): Response
    {
        try {
            $this->booksService->deleteBook($id);
        } catch (Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(['index']);
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionShowModal(int $id): string
    {
        $subscribeForm = new SubscribeForm();
        $book = $this->booksService->findBook($id);
        $subscribeForm->author_id = $book->author_id;
        $subscribeForm->author_name = $book->author->fullName;

        return $this->renderAjax('_subscribe', [
            'subscribeForm' => $subscribeForm,
        ]);
    }

    public function actionSubscribe(): Response|string
    {
        $subscribeForm = new SubscribeForm();
        $subscribeService = new SubscribeService();
        $authorService = new AuthorsService();

        try {
            if($subscribeForm->load(Yii::$app->request->post())) {

                $author = $authorService->findAuthor($subscribeForm->author_id);
                $subscribeForm->author_name = $author->fullName;

                if(!$subscribeForm->validate()) {
                    return $this->renderAjax('_subscribe', [
                        'subscribeForm' => $subscribeForm,
                    ]);
                }

                if($subscribeForm->subscribe) {
                    $subscribeService->subscribe($subscribeForm);
                    Yii::$app->session->setFlash(
                        'success',
                        'Номер ' . $subscribeForm->phone . ' подписан на sms-оповещения при поступлении новых книг автора: ' . $subscribeForm->author_name
                    );
                } else {
                    $subscribeService->unsubscribe($subscribeForm);
                    Yii::$app->session->setFlash(
                        'success',
                        'Номер ' . $subscribeForm->phone . ' отписан от sms-оповещений при поступлении новых книг автора: ' . $subscribeForm->author_name
                    );
                }
            }
        } catch (Throwable $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(['index']);
    }
}
