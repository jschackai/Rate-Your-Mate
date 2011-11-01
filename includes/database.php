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
        var $num_active_users;   //Number of active users viewing site
        var $num_members;        //Number of signed-up users

        /* Class constructor */
        function MySQLDB(){
            /* Make connection to database */
            try{
                $this->connection =  new PDO(DB_DSN,DB_USER,DB_PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){echo DB_ERR;}
        }

        /**
        * confirmUserPass - Checks whether or not the given
        * username is in the database, if so it checks if the
        * given password is the same password in the database
        * for that user. If the user doesn't exist or if the
        * passwords don't match up, it returns an error code
        * (1 or 2). On success it returns 0.
        */
        function confirmUserPass($username, $password){
            /* Verify that user is in database */
            try{
                $sth = $this->connection->prepare("SELECT password FROM ".TBL_USERS." WHERE username = :uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->execute();
                $dbarray = $sth->fetch(PDO::FETCH_ASSOC);
                $count = $sth->rowCount();
            }catch(Exception $e){
                echo DB_ERR;
            }
            if(!$count || ($count < 1)){return 1;} //Indicates username failure
            $hash=$dbarray['password'];
            /* Retrieve password from result, strip slashes */

            /* Validate that password is correct */
            $hasher=$dbarray['password'];
            // The first 64 characters of the hash is the salt
            $salt=substr($hasher,0,64); 
            $hash=$salt.$password; 
            // Hash the password as we did before
            for($i=0;$i<10000;$i++){$hash=hash('sha256', $hash);} 
            $hash=$salt.$hash; 
            $sth=null;
            if($hash==$hasher){
                return 0; //Success! Username and password confirmed
            }else{
                return 2; //Indicates password failure
            }
        }

        /**
        * confirmUserID - Checks whether or not the given
        * username is in the database, if so it checks if the
        * given userid is the same userid in the database
        * for that user. If the user doesn't exist or if the
        * userids don't match up, it returns an error code
        * (1 or 2). On success it returns 0.
        */
        function confirmUserID($username, $userid){
            /* Verify that user is in database */
            try{  
                $sth = $this->connection->prepare("SELECT UID FROM ".TBL_USERS." WHERE username = :uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->execute();
                $dbarray = $sth->fetch(PDO::FETCH_ASSOC);
                $count = $sth->rowCount();
            }catch(Exception $e){
                echo DB_ERR;
            }
            if(!$count || ($count < 1)){return 1;} //Indicates username failure

            /* Retrieve userid from result, strip slashes */
            $dbarray['UID'] = stripslashes($dbarray['UID']);
            $userid = stripslashes($userid);
            $sth=null;
            /* Validate that userid is correct */
            if($userid == $dbarray['UID']){
                return 0; //Success! Username and userid confirmed
            }else{
                return 2; //Indicates userid invalid
            }
        }

        /**
        * addNewUser - Inserts the given (username, password, email)
        * info into the database. Appropriate user level is set.
        * Returns true on success, false otherwise.
        */
        function addNewUser($username, $password, $email){
            $time = time();
            /* If admin sign up, give admin user level */
            if(strcasecmp($username, ADMIN_NAME) == 0){
                $ulevel = ADMIN_LEVEL;
            }else{
                $ulevel = USER_LEVEL;
            }
            try{
                $sth = $this->connection->prepare("INSERT INTO ".TBL_USERS." VALUES (:uname, :password, '0', :ulevel, :email, :time)");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->bindParam(':password', $password, PDO::PARAM_STR);
                $sth->bindParam(':ulevel', $ulevel, PDO::PARAM_INT);
                $sth->bindParam(':email', $email, PDO::PARAM_STR);
                $sth->bindParam(':time', $time, PDO::PARAM_STR);
                return $sth->execute();
            }catch(Exception $e){
                echo DB_ERR;
            }
            $q = "INSERT INTO ".TBL_USERS." ";
            $sth=null;
        }

        /**
        * usernameTaken - Returns true if the username has
        * been taken by another user, false otherwise.
        */
        function usernameTaken($username){
            if(!get_magic_quotes_gpc()){
                $username = addslashes($username);
            }
            try{
                $sth = $this->connection->prepare("SELECT username FROM ".TBL_USERS." WHERE username = :uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                return $sth->execute();
                $count = $sth->rowCount();
                return ($count > 0);
            }catch(Exception $e){
                echo DB_ERR;
            }
            $sth=null;
        }

        /**
        * updateUserField - Updates a field, specified by the field
        * parameter, in the user's row of the database.
        */
        function updateUserField($username, $field, $value){
            try{
                $sth = $this->connection->prepare("UPDATE ".TBL_USERS." SET ".$field." = :value WHERE username = :uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                if(is_int($value))
                    $param = PDO::PARAM_INT;
                elseif(is_bool($value))
                    $param = PDO::PARAM_BOOL;
                elseif(is_null($value))
                    $param = PDO::PARAM_NULL;
                elseif(is_string($value))
                    $param = PDO::PARAM_STR;
                else
                    $param = FALSE;                   
                if($param)
                    $sth->bindValue(":value",$value,$param);
                return $sth->execute();
            }catch(Exception $e){
                echo $e;
                $sth=null;
            }
        }

        /**
        * getUserInfo - Returns the result array from a mysql
        * query asking for all information stored regarding
        * the given username. If query fails, NULL is returned.
        */
        function getUserInfo($username){
            try{  
                $sth = $this->connection->prepare("SELECT * FROM ".TBL_USERS." WHERE username = :uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->execute();
                $dbarray = $sth->fetch(PDO::FETCH_ASSOC);
                $count = $sth->rowCount();
            }catch(Exception $e){
                echo DB_ERR;
            }
            $sth=null;
            /* Error occurred, return given name by default */
            if(!$count || ($count < 1)){
                return NULL;
            }
            /* Return result array */ 
            return $dbarray;
        }


        /**
        * getNumMembers - Returns the number of signed-up users
        * of the website, banned members not included. The first
        * time the function is called on page load, the database
        * is queried, on subsequent calls, the stored result
        * is returned. This is to improve efficiency, effectively
        * not querying the database when no call is made.
        */
        function getNumMembers(){// Calculate number of site members
            if($this->num_members < 0){
                try{  
                    $sth = $this->connection->prepare("SELECT * FROM ".TBL_USERS);
                    $sth->execute();
                    $count = $sth->rowCount();
                }catch(Exception $e){
                    echo DB_ERR;
                }
                $this->num_members = $count;
            }
            $sth=null;
            return $this->num_members;
        }

        /**
        * calcNumActiveUsers - Finds out how many active users
        * are viewing site and sets class variable accordingly.
        */
        function calcNumActiveUsers(){// Calculate number of users at site
            if($this->num_members < 0){
                try{  
                    $sth = $this->connection->prepare("SELECT * FROM ".TBL_ACTIVE);
                    $sth->execute();
                    $count = $sth->rowCount();
                }catch(Exception $e){
                    echo DB_ERR;
                }
                $this->num_active_users = $count;
                $sth=null;
            }
        }

        /**
        * addActiveUser - Updates username's last active timestamp
        * in the database, and also adds him to the table of
        * active users, or updates timestamp if already there.
        */
        function addActiveUser($username,$time){
            try{  
                $sth = $this->connection->prepare("UPDATE ".TBL_USERS." SET timestamp = :time WHERE username = :uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->bindParam(':time', $time, PDO::PARAM_STR);
                $sth->execute();
            }catch(Exception $e){
                echo DB_ERR;
            }

            if(!TRACK_VISITORS) return;
            try{  
                $sth = $this->connection->prepare("REPLACE INTO ".TBL_ACTIVE." VALUES (:uname,:time)");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->bindParam(':time', $time, PDO::PARAM_STR);
                $sth->execute();
            }catch(Exception $e){
                echo DB_ERR;
            }
            $this->calcNumActiveUsers();
            $sth=null;
        }

        /* removeActiveUser */
        function removeActiveUser($username){
            if(!TRACK_VISITORS) return;
            try{  
                $sth = $this->connection->prepare("DELETE FROM ".TBL_ACTIVE." WHERE username=:uname");
                $sth->bindParam(':uname', $username, PDO::PARAM_STR);
                $sth->execute();
            }catch(Exception $e){
                echo DB_ERR;
            }
            $this->calcNumActiveUsers();
            $sth=null;
        }

        /* removeInactiveUsers */
        function removeInactiveUsers(){
            if(!TRACK_VISITORS) return;
            $timeout = time()-USER_TIMEOUT*60;
            try{  
                $sth = $this->connection->prepare("DELETE FROM ".TBL_ACTIVE." WHERE timestamp=:timeout");
                $sth->bindParam(':timeout', $timeout, PDO::PARAM_STR);
                $sth->execute();
            }catch(Exception $e){
                echo DB_ERR;
            }
            $this->calcNumActiveUsers();
            $sth=null;
        }

        /*Creates a GUID for dB use */
        function getGuid(){
            return $guid=(function_exists('com_create_guid') === true)? trim(com_create_guid(),'{}'):sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',mt_rand(0,65535),mt_rand(0,65535),mt_rand(0,65535),mt_rand(16384,20479),mt_rand(32768,49151),mt_rand(0,65535),mt_rand(0,65535),mt_rand(0,65535));
        }

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
                $sth = $this->connection->prepare("SELECT DISTINCT cname, CLID FROM Classes, Users WHERE Classes.instructor=:id");
                $sth->bindParam(':id', $id, PDO::PARAM_STR);
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
