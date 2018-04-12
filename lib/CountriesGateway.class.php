<?php
class CountriesGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "Countries";
    }
    
    protected function getSelectStatement() {
    return "SELECT * FROM Countries";
    }
    
    protected function getOrderFields() {
        return "CountryName";
    }
    
    protected function getPrimaryKeyName() {
        return "ISO";
    }
}
?>