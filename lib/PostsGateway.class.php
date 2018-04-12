<?php
class PostsGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "Posts";
    }
    
    protected function getSelectStatement() {
    return "SELECT * FROM Posts ";
    }
    
    protected function getOrderFields() {
        return "";
    }
    
    protected function getPrimaryKeyName() {
        return "PostID";
    }
}
?>