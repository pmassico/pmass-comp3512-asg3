<?php
class UsersGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "Users";
    }
    
    protected function getSelectStatement() {
    return "SELECT * FROM Users ";
    }
    
    protected function getOrderFields() {
        return "";
    }
    
    protected function getPrimaryKeyName() {
        return "UserID";
    }
}
?>