<?php
class ImageDetailsGateway extends TableDataGateway {

    public function __construct($connect) {
        parent::__construct($connect);
    }
    
    protected function getTableName() {
        return "ImageDetails";
    }
    
    protected function getSelectStatement () {
        return "SELECT * FROM ImageDetails ";
    }
    
    
    protected function getOrderFields() {
        return '';
    }
    
    protected function getPrimaryKeyName() {
        return "ImageID";
    }
    
    public function findByParameter($parameter=array())
    {
      $sql = $this->getSelectStatementParam($parameter[0]) . ' WHERE ' .
      $parameter[0] . '=:key';
      $statement = DatabaseHelper::runQuery($this->connection, $sql,
      Array(':key' => $parameter[1]));
      return $statement;
    }
}
?>