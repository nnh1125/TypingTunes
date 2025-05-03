<?php
    echo "<form action=\"#\" id=\"filter\">";

        echo "<label>";

            echo "Sort by:";

            echo "<select name=\"sort\" id=\"sort-select\">";
                echo "<option value=\"wpm\">WPM (speed)</option>";
                echo "<option value=\"acc\">Accuracy</option>";
                echo "<option value=\"new\">Recency</option>";
            echo "</select>";

        echo "</label>";

        echo "<input type=\"submit\" value=\"Refresh\">";

    echo "</form>";
?>
