<?php
    /**
    * Database.php
    * 
    * This Database class is meant to simplify the task of accessing information from the website's database.
    */

    include("constants.php");
    include("functions.php");
    class MySQLDB{
        var $connection;         //The MySQL database connection

        /* Class constructor */
        function MySQLDB(){
            /* Make connection to database */
            try{
                $this->connection =  new PDO(DB_DSN,DB_USER,DB_PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                echo DB_ERR;
            }


        }//end constructor

        /**
        * query - Performs the given query on the database and
        * returns the result, which may be false, true or a
        * resource identifier.
        */
        function query($query){
            try{  
                $sth = $this->connection->prepare(":query");
                $sth->bindParam(':query', $query, PDO::PARAM_STR);
                return $sth->execute();
            }catch(Exception $e){
                echo DB_ERR;
            }
            $sth=null;
        }

        /**
         * getProjects - returns an array of projects for the given ID and user level
         */
        function getProjects($id,$lvl){
          if($lvl==5){
            try{  
                    $sth = $database->connection->prepare("SELECT * FROM Users LEFT JOIN Projects ON instructor=UID WHERE UID =:uid");
                    $sth->bindParam(':uid', $id, PDO::PARAM_STR);   
                    $sth->execute();
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                        $projects[]=array('pid'=>$row['PID'],'pname'=>$row['pname']);
                    }
          }catch(Exception $e){
                echo $e;
            }
        }else{
          try{  
                    $sth = $database->connection->prepare("SELECT * FROM Projects LEFT JOIN Groups ON Groups.PID=Projects.PID WHERE Groups.UID =:uid");
                    $sth->bindParam(':uid', $id, PDO::PARAM_STR);   
                    $sth->execute();
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                        $projects[]=array('pid'=>$row['PID'],'pname'=>$row['pname']);
                    }
          }catch(Exception $e){
                echo $e;
            }
        }
        return $projects;
        }                                  

        /**
        * getStudents - returns an array of all students with associated IDs
        */
        function getStudents(){
            $students=array();
            try{
                $sth = $this->connection->prepare("SELECT fname,lname,UID FROM Users WHERE ulevel=1 ORDER BY lname ASC, fname ASC");   
                $sth->execute();
                while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                    $students[]=array('id'=>$row['UID'],'fname'=>$row['fname'],'lname'=>$row['lname']);
                }
            }catch(Exception $e){
                echo $e;
            }
            return $students;
        }
        
        /**
        * getRoster - returns an array of all students in provided class, along with associated IDs
        */
        function getRoster($class){
            $roster=array();
            try{
                $sth = $this->connection->prepare("SELECT fname,lname,UID FROM Users, Enrollment WHERE Users.UID=Enrollment.user AND Enrollment.class=:class ORDER BY lname ASC, fname ASC");
                $sth->bindParam(':class', $class, PDO::PARAM_STR);
                $sth->execute();
                while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                    $roster[]=array('id'=>$row['UID'],'fname'=>$row['fname'],'lname'=>$row['lname']);
                }
            }catch(Exception $e){
                echo $e;
            }
            return $roster;
        }
        
        /**
        * getClasses - returns an array of all classes for a provided instructor
        */
        function getClasses($id){
            $classes=array();
            try{
                $sth = $this->connection->prepare("SELECT cname, CLID FROM Classes, Users WHERE Classes.instructor=Users.UID");
                $sth->bindParam(':class', $class, PDO::PARAM_STR);
                $sth->execute();
                while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                    $classes[]=array('name'=>$row['cname'],'id'=>$row['CLID']);
                }
            }catch(Exception $e){
                echo $e;
            }
            return $classes;
        }
        
    };//end MySQLDB

    /* Create database connection */
    $database = new MySQLDB;
?>
