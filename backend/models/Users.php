<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required', 'on' => ['CreateUser', 'UpdateUserPassword']],
            ['password', 'string', 'min' => 6, 'on' => ['CreateUser', 'UpdateUserPassword']],

            ['password_repeat', 'required', 'on' => ['CreateUser', 'UpdateUserPassword']],
            ['password_repeat', 'string', 'min' => 6, 'on' => ['CreateUser', 'UpdateUserPassword']],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message'=> Yii::t('app','Passwords do not match. Try again !.'), 'on' => ['CreateUser', 'UpdateUserPassword']],

            [['partner_id', 'status', 'created_at', 'updated_at'], 'integer'],

            [['name', 'username', 'email', 'type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'CreateUser' => [
                'name', 'username', 'email', 'password', 'password_repeat', 'partner_id', 'type', 'status'
            ],
            'UpdateUser' => [
                'name', 'username', 'email', 'password', 'password_repeat', 'partner_id', 'type', 'status'
            ],
            'UpdateUserPassword' => [
                'password', 'password_repeat'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'partner_id' => Yii::t('app', 'Partner'),
            'name' => Yii::t('app', 'Name'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getTypes()
    {
        return [
            'admin' => Yii::t('app','Admin'),
            'partner' => Yii::t('app','Partner'),
            'client' => Yii::t('app','Client'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getStatusOptions()
    {
        return [
            10 => Yii::t('app','Active'),
            0 => Yii::t('app','Inactive'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getStatusLabel()
    {
        return $this->status==10 ? Yii::t('app','Active') : Yii::t('app','Inactive');
    }

    /**
     * @inheritdoc
     */
    public function getPartners()
    {
        return $this->findAll([
            'type' => 'partner',
            'status' => 10
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getUsersByPartner($retaile_id)
    {
        return $this->findAll([
            'type' => 'partner',
            'partner_id' => $retaile_id,
            'status' => 10
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getPartnerLabel()
    {
        if($this->partner_id!=0) {
            return $this->findOne([
                'type' => 'client',
                'partner_id' => $this->partner_id,
                'status' => 10
            ])->username;
        }else{
            return Yii::t('app', 'Any linked partner');
        }
    }

    /**
     * @inheritdoc
     */
    public function createUser()
    {
        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->partner_id = $this->partner_id ? $this->partner_id : 0;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->type = $this->type;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

            return true;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function updateUser()
    {
        if ($this->validate()) {
            $user = User::findOne($this->id);
            $user->name = $this->name;
            $user->partner_id = $this->partner_id ? $this->partner_id : 0;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->type = $this->type;
            $user->save(false);

            return true;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function updateUserPassword()
    {
        if ($this->validate()) {
            $user = User::findOne($this->id);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

            return true;
        }

        return null;
    }
}
