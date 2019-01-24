
<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/billboard/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>

<h2>Halifax Quests</h2>
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
<?php>
$dbhost = "";
$dbuser = "";
$dbpass = "";
$dbname = "rdmdb";
// Establish connection to database
try{
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
// Query Database and Build Raid Billboard
try 
{
    $sql = "SELECT pokedex.name, pokestop.name , pokestop.lat, pokestop.lon FROM rdmdb.pokestop
    inner join pokedex on pokestop.quest_pokemon_id = pokedex.pokemon_id  order by quest_pokemon_id asc";   
        $google_url = "http://maps.google.com/?q=";
        $result = $pdo->query($sql);
        if($result->rowCount() > 0){
            echo "<table border='1', id = 'myTable';>";
                echo "<tr>";
                    echo "<th>Pokemon</th>";
                    echo "<th>Gym Name</th>";
                    echo "<th>Location</th>";
                echo "</tr>";
            while($row = $result->fetch()){
                echo "<tr class='header'>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . $row[1] . "</td>";
                    echo "<td><a href='$google_url $row[2].",",$row[3].'>Link</a></td>"; 
                echo "</tr>";
            }
            echo "</table>";
// Free result set
        unset($result);
    } else{
        echo "No records matching your query were found.";
    }
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
// Close connection
unset($pdo);



?>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
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