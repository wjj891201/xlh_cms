<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\rbac;

use Yii;
use yii\base\Object;

/**
 * Assignment represents an assignment of a role to a user.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.04
 */
class Assignment extends Object
{

    /**
     * @var string|integer user ID (see [[\yii\web\User::id]])
     */
    public $userId;

    /**
     * @var string the role name
     */
    public $roleName;

    /**
     * @var integer UNIX timestamp representing the assignment creation time
     */
    public $createdAt;

}
