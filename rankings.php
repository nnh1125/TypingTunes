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
    
      <h2>Rankings</h2>

      <?php
        include "connect_db.php";

        $sort_order = "wpm";
        if(isset($_GET["sort"]))
          $sort_order = $_GET["sort"];

        if($sort_order == "wpm")
          $sql = "SELECT * FROM games ORDER BY wpm DESC";
        else if($sort_order == "acc")
          $sql = "SELECT * FROM games ORDER BY accuracy DESC";
        else // $sort_order == "new"
          $sql = "SELECT * FROM games ORDER BY id DESC";
        
        $result = $conn->query($sql);

        include "sort_form.php";
        echo "<table>";

        // Header row
        echo "<tr>";
        echo "<th>Ranking</th>";
        echo "<th>Username</th>";
        echo "<th>Song</th>";
        echo "<th>Artist</th>";
        echo "<th>WPM</th>";
        echo "<th>Accuracy</th>";
        echo "</tr>";

        $current_rank = 1;

        // Build the table
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $current_rank . "</td>";
          echo "<td>" . $row["username"] . "</td>";
          echo "<td>" . $row["title"] . "</td>";
          echo "<td>" . $row["artist"] . "</td>";
          echo "<td>" . $row["wpm"] . "</td>";
          echo "<td>" . $row["accuracy"] . "</td>";
          echo "</tr>";

          $current_rank++;
        }

        echo "</table>";
      ?>
    </section>
  </main>

  <footer>
    <div id = "footerLink"><a href="login.php">Log Out</a></div>
  </footer>

  <script>
      // Function to add timestamp to links
function addTimestampToLinks() {
    // Select all anchor tags
    const links = document.querySelectorAll('a');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Only modify internal links
            if (!this.href.includes('http') || this.href.includes(window.location.hostname)) {
                // Add timestamp only if not already present
                if (!this.href.includes('_=')) {
                    const separator = this.href.includes('?') ? '&' : '?';
                    this.href += separator + '_=' + new Date().getTime();
                }
            }
        });
    });
}

// Run the function when the page loads
document.addEventListener('DOMContentLoaded', addTimestampToLinks);

  </script>


</body>
</html>