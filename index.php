<?php
error_reporting(0);
session_start();
require 'dbconfig.php';

//get data from firebase
$refid = "Users";

$rdb= $database->getReference($refid)->getValue();
 



$fname= $_POST['fname'];
$lname= $_POST['lname'];
$Pass= $_POST['password'];
$date= $_POST['date'];
$id=$_POST['id'];
//first name + last name
$tb =[
          'nom' => $fname,  
            'prenom' => $lname
];
//buttons
//Add Button
if($_POST['btnadd']){
  
    //firebase
    

$AppData = [
	'username'	=>	$tb,
	'password'	=>	$Pass,
    'datess' => $date
];

$ref='Users/';
$postdata = $database->getReference($ref)->push($AppData);
    
    
    header("location: index.php");
}
//update button
if($_POST['btnedt']){
    
    //firebase
    

$AppData = [
	'username'	=>	$tb,
	'password'	=>	$Pass,
    'datess' => $date
];

$ref='Users/'.$id;
$updatedata = $database->getReference($ref)->update($AppData);
    
    
    header("location: index.php");
}
//delete button
if($_POST['btndel']){
   
    
    //firebase
    $ref='Users/'.$id;
    $database->getReference($ref)->remove();
    header("location: index.php");
}

?>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
         <!-- style -->   
        <style>


#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#info {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#info th, #info td {
  text-align: left;
  padding: 12px;
}

#info tr {
  border-bottom: 1px solid #ddd;
}

#info tr.header, #info tr:hover {
  background-color: #f1f1f1;
            } 
.MyForm{
    margin: auto;
  width: 50%;
  border: 3px solid #ddd;
  padding: 10px;
            }
            body {
    text-align: center;
}
form {
    display: inline-block;
}
.log{
    float: right;
            }
.navbar{
    margin-bottom: 20px;
            }
        </style>
    </head>
     <body>
         <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a href="#" class="navbar-brand">Admin Control Panel</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item log">
                    <a href="index.php?logout=1" class="nav-link"></a>
                </li>
                
            </ul>
        </div>

    </nav>
         
         
<form method="post">
    <div class="MyForm">
    <label>Nom</label><br>
        <input type="text" id="fname" name="fname"><br>
    <label>Prenom</label><br>
        <input type="text" id="lname" name="lname"><br>    
    <label>prise</label><br>
        <input type="text" id="password" name="password"><br>
   
        <input type="hidden" id="date" name="date" value="<?= time(); ?>">
        
        <input type="hidden" id="id" name="id" >
        <br>
   <br>
        
        <input type="submit" name="btnadd" value="Add"/>
        <input type="submit" name="btnedt" value="Edit"/>
        <input type="submit" name="btndel" value="Delete"/>
        
    
    </div>
    <br><br>
    
    <div>
        <label>Search</label>    <br><br>
    <input type="text" id="myInput" onkeyup="myFilter()" placeholder="Search for emails.." title="Type in a name">
    </div>
    
    <br><br>
    <table border="1" id="info">
    <tr class="header">
        <th>Fname</th>
        <th>Lname</th>
        <th>Prise</th>
        <th>Date</th>
        <th>Long</th>
        <th>ID</th>
        </tr>
        <?php 
        $now = time();
            echo "Now : ".$now;
        foreach($rdb as $key => $row)
        {
           
            $rows = $row["username"];
          
            
            echo "<tr>";
            echo "<td>" . $rows["nom"] . "</td>";
             echo "<td>" . $rows["prenom"] . "</td>";
            echo "<td>" . $row["password"] . "</td>";
            
           
            
            echo "<td>" .  date('d/m/Y ',$row["datess"] ) . "</td>";
            
            
            //calculate the days
            $now = time(); // or your date as well
$your_date = $row["datess"];
$datediff = $now - $your_date;
            $datedif= round($datediff / (60 * 60 * 24));
            echo "<td>" ;
            echo round($datediff / (60 * 60 * 24));
            echo "</td>";
            
            echo "<td>" . $key . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</form>

<script>
var tbl = document.getElementById('info');
    for(var i=1; i<tbl.rows.length;i++){
        tbl.rows[i].onclick=function(){
            
         document.getElementById("fname").value = this.cells[0].innerHTML;
          
         document.getElementById("lname").value = this.cells[1].innerHTML;
         document.getElementById("password").value = this.cells[2].innerHTML; 
            
        
            
            document.getElementById("id").value = this.cells[5].innerHTML;  
         
        }
    }

    
    function myFilter() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("info");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
         
         <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
         
    </body>