<?php
class CitiesGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "Cities";
    }
    
    protected function getSelectStatement() {
    return "SELECT * FROM Cities";
    }
    
    protected function getOrderFields() {
        return "AsciiName";
    }
    
    protected function getPrimaryKeyName() {
        return "CityCode";
    }
}
?>