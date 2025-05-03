<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <title>Typing Tunes</title>
</head>
<body>
  <header>
    <div class="history">
      <a href="history.php">History</a>
    </div>
    <h1><a href="type.html">Typing Tunes</a></h1>
    <div class="rankings">
      <a href="rankings.php">Rankings</a>
    </div>
  </header>

  <main>
    <section class="song-list">
      <?php
        if(!isset($_COOKIE["username"])) {
          echo "Unable to retrieve history: username not found!";
          die();
        }
        $username = $_COOKIE["username"];

        include "connect_db.php";

        $sort_order = "wpm";
        if(isset($_GET["sort"]))
          $sort_order = $_GET["sort"];

        if($sort_order == "wpm")
          $sql = "SELECT * FROM games WHERE username = \"$username\" ORDER BY wpm DESC LIMIT 10";
        else if($sort_order == "acc")
          $sql = "SELECT * FROM games WHERE username = \"$username\" ORDER BY accuracy DESC LIMIT 10";
        else // $sort_order == "new"
          $sql = "SELECT * FROM games WHERE username = \"$username\" ORDER BY id DESC LIMIT 10";
        
        $result = $conn->query($sql);

        echo "<h2>$username's recent typing history</h2>";
        include "sort_form.php";
        echo "<table>";

        // Header row
        echo "<tr>";
        echo "<th>Song</th>";
        echo "<th>Artist</th>";
        echo "<th>WPM</th>";
        echo "<th>Accuracy</th>";
        echo "</tr>";

        // Build the table
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["title"] . "</td>";
          echo "<td>" . $row["artist"] . "</td>";
          echo "<td>" . $row["wpm"] . "</td>";
          echo "<td>" . $row["accuracy"] . "</td>";
          echo "</tr>";
        }

        echo "</table>";
      ?>
    </section>

    <script>
      const queryString = window.location.search;
      const params = new URLSearchParams(queryString);
      for (const pair of params.entries()) {
        if(pair[0] == "sort") {
          document.getElementById("sort-select").value = pair[1];
          break;
        }
      }
    </script>
  </main>

  <footer>
    <div id = "footerLink"><a href="login.php">Log Out</a></div>
  </footer>
</body>
</html>
