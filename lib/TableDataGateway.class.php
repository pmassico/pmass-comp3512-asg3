<?php
/*
  Encapsulates common functionality needed by all table gateway objects.
 */
 
abstract class TableDataGateway
{
   // contains connection
   protected $connection;
   
   /*
      Constructor is passed a database adapter (example of dependency injection)
   */
   public function __construct($connect) 
   {
      if (is_null($connect) )
         throw new Exception("Connection is null");
         
      $this->connection = $connect;
   }
   
   // ***********************************************************
   // ABSTRACT METHODS
   
   /*
     The name of the table in the database
   */    
   abstract protected function getSelectStatement();

   abstract protected function getTableName();
   /*
     A list of fields that define the sort order
   */   
   abstract protected function getOrderFields();
   
   /*
     The name of the primary keys in the database ... this can be overridden by subclasses
   */    
   abstract protected function getPrimaryKeyName();

   
   // ***********************************************************
   // PUBLIC FINDERS 
   //
   // All of these finders return either a single or array of the appropriate DomainObject subclasses
   //
   
   /*
      Returns all the records in the table
   */
   public function findAll($sortFields=null)
   {
      $sql = $this->getSelectStatement();
      // add sort order if required
      if (! is_null($sortFields)) {
         $sql .= ' ORDER BY ' . $sortFields;
      }
      
      $statement = DatabaseHelper::runQuery($this->connection, $sql, null);
      return $statement->fetchAll();
   }
   
   public function findAllParam($param) {
      
      $sql = $this->getSelectStatement() . ' WHERE ' .$param[0] . $param[1] . ':search';
      
      //include second parameter
      if(count($param)>3) {
         $sql .= $param[3] . $param[4] . $param[5] . ':search2';
         $statement = DatabaseHelper::runQuery($this->connection, $sql, Array(':search' => $param[2],
                                                                              ':search2' => $param[6]));
      } else {
         $statement = DatabaseHelper::runQuery($this->connection, $sql, Array(':search' => $param[2]));
      }
      
      return $statement->fetchAll();
      
   }
   
   /*
      Returns all the records in the table sorted by the specified sort order
   */
   public function findAllSorted($ascending)
   {
      $sql = $this->getSelectStatement() . ' ORDER BY ' .
      $this->getOrderFields();
      if (!$ascending) {
         $sql .= " DESC";
      }
      $statement = DatabaseHelper::runQuery($this->connection, $sql, null);
      return $statement->fetchAll();
   }

   
   /*
      Returns a record for the specificed ID
   */
   public function findById($id)
   {
      $sql = $this->getSelectStatement() . ' WHERE ' .
      $this->getPrimaryKeyName() . '=:id';
      $statement = DatabaseHelper::runQuery($this->connection, $sql,
      Array(':id' => $id));
      return $statement->fetch();
   }
   
   
   public function findAllJoin($otherTable, $otherTableKey, $sortFields=null, $param=null) {
      
      $sql = $this->getSelectStatement()." JOIN $otherTable
      ON ".$this->getTableName().".".$this->getPrimaryKeyName()." = $otherTable.$otherTableKey";
      
      if($param!=null) {
         $sql .= " WHERE ".$param[0] . $param[1] . ':search';
      }
      
      $sql .= " GROUP BY ".$this->getTableName().".".$this->getPrimaryKeyName();
      
      if (! is_null($sortFields)) {
         $sql .= ' ORDER BY ' . $sortFields;
      }
      
      if($param!=null) {
         $statement = DatabaseHelper::runQuery($this->connection, $sql, Array(':search' => $param[2]));
      } else {
         $statement = DatabaseHelper::runQuery($this->connection, $sql, null);
      }
      
      
      return $statement->fetchAll();
      
   }
}

?>