<?php
class UsersLoginGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "UsersLogin";
    }
    
    protected function getSelectStatement() {
    return "SELECT * FROM UsersLogin ";
    }
    
    protected function getOrderFields() {
        return "";
    }
    
    protected function getPrimaryKeyName() {
        return "UserID";
    }
    
}
?>