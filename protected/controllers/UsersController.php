<?php

class UsersController extends Controller
{

    public $layout = 'column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter - login,logout'
            )
        );
    }

   /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->render('error');
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionView()
    {
        if (Yii::app()->user->checkAccess('viewusers'))
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id != 1';
            $pages = new CPagination(User::model()->count($criteria));
            $pages->pageSize = Yii::app()->params['perPageCount'];
            $pages->applyLimit($criteria);
            $models = User::model()->findAll($criteria);
            $this->render('view', array(
                'models' => $models,
                'pages' => $pages
            ));
        }
        else
        {
            $this->redirect("/users/");
        }
    }

    public function actionAdd()
    {
        if (Yii::app()->user->checkAccess('addusers'))
        {
            $model = new User("create");
            if (isset($_POST['addSub']))
            {
                $model->setAttributes($_POST['User']);
                if ($model->isAlreadyExist())
                {
                    Yii::app()->user->setFlash('error', 'Email-id or username already exist!');
                }
                else
                {
                    if ($model->validate())
                    {
                        $model->password = md5($model->password);
                        $model->created = date("Y-m-d H:i");
                        if ($model->save(false))
                        {
                            Yii::app()->user->setFlash('success', 'User details has been saved successfully!');
                            $this->redirect(array('view'));
                            exit;
                        }
                        else
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                    }
                }
            }
            $roles = Role::getAll();
            $rolesList = $this->getList($roles, "id", "name");
            $this->render('add', array('rolesList' => $rolesList, 'model' => $model));
        }
        else
        {
            $this->redirect("/users/");
        }
    }

    public function actionEdit()
    {
        if (Yii::app()->user->checkAccess('editusers'))
        {
            if (isset($_GET['id']))
            {
                $id = $_GET['id'];
                $model = User::getUser($id);
                if ($model)
                {
                    $model->scenario = "create";
                    $oldPassword = $model->password;
                    if (isset($_POST['addSub']))
                    {
                        $model->setAttributes($_POST['User']);
                        if ($model->isAlreadyExist($id))
                        {
                            Yii::app()->user->setFlash('error', 'Email-id or username already exist!');
                        }
                        else
                        {
                            if ($model->validate())
                            {
                                if ($model->password != "******")
                                    $model->password = md5($model->password);
                                else
                                    $model->password = $oldPassword;
                                if ($model->save(false))
                                {
                                    Yii::app()->user->setFlash('success', 'User details has been updated successfully!');
                                    $this->redirect(array('view'));
                                    exit;
                                }
                                Yii::app()->user->setFlash('error', 'Operation Failed!');
                            }
                        }
                    }
                    $roles = Role::getAll();
                    $rolesList = $this->getList($roles, "id", "name");
                    $this->render('add', array('rolesList' => $rolesList, 'model' => $model));
                    exit;
                }
            }
            Yii::app()->user->setFlash('error', 'Invalid operation!');
            $this->redirect(array('view'));
            exit;
        }
        else
        {
            $this->redirect("/users/");
        }
    }

    public function actionStatus()
    {
        if (Yii::app()->user->checkAccess('edituserstatus'))
        {  
            if (isset($_GET['DId']) || isset($_GET['EId']))
            {
                $id = $_GET['DId'] ? $_GET['DId'] : $_GET['EId'];
                $status = $_GET['DId'] ? User::STATUS_DISABLED : User::STATUS_ACTIVE;
                $model = User::getUser($id);
                if ($model)
                {
                    $model->status = $status;
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Status has been changed successfully!');
                        $this->redirect(array('view'));
                        exit;
                    }
                }
            }
            Yii::app()->user->setFlash('error', 'Invalid operation!');
            $this->redirect(array('view'));
            exit;
        }
        else
        {
            $this->redirect("/users/");
        }
    }

    public function actionDelete()
    {

        if (Yii::app()->user->checkAccess('deleteuser'))
        {
            if (isset($_GET['id']))
            {
                if (User::model()->deleteByPk($_GET['id']))
                {
                    Yii::app()->user->setFlash('success', 'User has been deleted successfully!');
                    $this->redirect(array('view'));
                    exit;
                }
                Yii::app()->user->setFlash('error', 'Operation failed!');
                $this->redirect(array('view'));
                exit;
            }
        }
        else
        {
            $this->redirect("/users/");
        }
    }

    public function getList($data, $value, $label, $default = true)
    {

        if ($default)
            $result = array("" => "-Select-");
        else
            $result = array();
        foreach ($data as $index => $model)
        {
            $result[$model->$value] = $model->$label;
        }
        return $result;
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

        $this->actionLogin();
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionDashboard()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->actionLogin();
            exit;
        }

        $this->render('dashboard');
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (!Yii::app()->user->isGuest)
        {
            $this->actionDashboard();
            exit;
        }
        $form = new LoginForm;
        if (isset($_POST['LoginForm']))
        {
            $form->attributes = $_POST['LoginForm'];
            if ($form->validate())
            {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->pageTitle = Yii::t('app', 'Login');
        $this->renderPartial('login', array('form' => $form));
    }

   /**
    * Logs out the current user and redirect to homepage.
    */
   public function actionLogout()
   {
           Yii::app()->user->logout();
           $this->redirect(Yii::app()->homeUrl);
   }

    public function actiontestPermission()
    {
//        $auth = Yii::app()->authManager;        
//        $role = $auth->createRole('2');
//        $role->addChild('viewusers');
//        $role->addChild('addusers');
//        $role->addChild('editusers');
//        $role->addChild('edituserstatus');
//        $role->addChild('deleteuser');
//       
//        $auth->assign('2', '2');
    }

    public function actionCreateRolePermission()
    {
        $auth = Yii::app()->authManager;

        $auth->createOperation('viewusers', 'view all the users');
        $auth->createOperation('addusers', 'add users');
        $auth->createOperation('editusers', 'edit the users');
        $auth->createOperation('edituserstatus', 'edituserstatus');
        $auth->createOperation('deleteuser', 'deleteuser');

        $role = $auth->createRole('1');
        $role->addChild('viewusers');
        $role->addChild('addusers');
        $role->addChild('editusers');
        $role->addChild('edituserstatus');
        $role->addChild('deleteuser');
        
        
        $role = $auth->createRole('2');
        $role->addChild('viewusers');
        $role->addChild('addusers');
        $role->addChild('editusers');
        $role->addChild('edituserstatus');
        $role->addChild('deleteuser');

        $auth->assign('1', '1');
        $auth->assign('2', '2');
    }

}
