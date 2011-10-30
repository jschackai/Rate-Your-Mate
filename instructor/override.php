<!-- Class Creation created by Jon Linden
This will access the
-->
<?php
    include('../includes/database.php'); //includes file witht he database funtions so we can use them here
    if(isset($_POST['IID'])){$user=htmlentities($_POST["IID"],ENT_QUOTES,'iso-8859-1');}else{$user="";}
    $classes=$database->getClasses($user);//function from the database.php file - returns an array of all classes for the provided instructor ($user)
    $pagetitle="Override Form | Rate Your Mate";//Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this iclude file has all the paths for the stylsheets and javascript in it.
?>

<body>
    Rate Your Mate - Override Form<br/>
    <?php
    echo $user;
?>
    <form name = "className" action = "link" method = "post">
        <!-- This will be pulled from database -->
        Class: <select name='class' id='class'>
                <option selected='selected'>Choose one...</option>
                <?php
                    foreach($classes as $class){
                        $id=$class['id'];
                        $name=$class['name'];
                        echo"<option value='$id'>$name</option>";
                    }
                ?>            
            </select>
        <br>
        <!-- this is dependent on class and will be updated after class is selected -->
        Student Name:

        <select>
            <option value="s1">Joe</option>
            <option value="s2">Jon</option>
            <option value="s3">Jeff</option>
            <option value="s4">Jen</option>
        </select>
        <br>
        Old Date and Time:
        <label for="oldDate"> October 26, 2011</label>
        <br>
        <!-- Pull in old date from data base and put in label -->
        New Date and Time:
        <!-- use fancy java script that Steven is using on the orginal creation page -->
        <br>
        <input type = "submit" value = "Update" />
    </form>
</body>
</html>