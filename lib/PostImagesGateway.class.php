<?php
class PostImagesGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "PostImages";
    }
    
    protected function getSelectStatement() {
    return "SELECT * FROM PostImages ";
    }
    
    protected function getOrderFields() {
        return "";
    }
    
    protected function getPrimaryKeyName() {
        return "ImageID";
    }
}
?>