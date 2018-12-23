<?php

use yii\db\Migration;

class m181112_060653_add_col_for_approve_user extends Migration
{

    public function up()
    {
        $this->addColumn('mh_approve_user', 'belong', $this->string(100)->comment('账号隶属')->after('username'));
        $this->addColumn('mh_approve_user', 'telphone', $this->integer(11)->comment('系列id')->after('email'));
    }

    public function down()
    {
        echo "m181112_060653_add_col_for_approve_user cannot be reverted.\n";

        return false;
    }

}
