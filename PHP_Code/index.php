<!-- This is the front controller that will determine the HTML code to be loaded.-->

<?php
// The “require 'opinion_poll_model.php';” loads the business logic class.

require 'opinion_poll_model.php';

// The “$model = new Opinion_poll_model();” creates an instance of the business logic class.

$model = new Opinion_poll_model();

// The “if (count($_POST) == 1)…” performs the data validation and uses JavaScript to display a message box if not candidate has been voted for.

if (count($_POST) == 1) {

    echo "<script>alert('You did not vote!');</script>";

}

// The “if (count($_POST) > 1)…” checks if a vote has been selected by counting the number of items in the $_POST array. If no item has been select, the $_POST will only contain the submit item. If a candidate has been chosen, the $_POST array will two elements, the submit and vote item. This code is also used to insert a new vote record and then display the results page.

if (count($_POST) > 1) {

    $ts = date("Y-m-d H:i:s");

    $option = $_POST['vote'][0];

    $sql_stmt = "INSERT INTO fav_author (`choice`,`ts`) VALUES ($option,'$ts')";

    $model->insert($sql_stmt);

    $sql_stmt = "SELECT COUNT(choice) choices_count FROM fav_author;";

    $choices_count = $model->select($sql_stmt);

    $libraries = array("Miguel de Cervantes", "Charles Dickens", "J.R.R. Tolkien", "Antoine de Saint-Exuper");

    $table_rows = '';
	
	$highlight = 0;
	
	$arry = []; 


    for ($i = 1; $i < 5; $i++) {

        $sql_stmt = "SELECT COUNT(choice) choices_count FROM fav_author WHERE choice = $i;";

        $result = $model->select($sql_stmt);
		
		array_push($arry,$result[0]);

        //$table_rows .= "<tr><td>" . $libraries [$i] . " Got:</td><td><b>" . $result[0] . "</b> votes</td></tr>";
		
		if ( $highlight < $result[0]) {
			$highlight = $result[0] ;
			}
			}
	for ($i = 0; $i < 4; $i++) {
		if ( $highlight == $arry[$i]) {
		$table_rows .= "<tr bgcolor='red'><td>" . $libraries [$i] . " :</td><td><b>" . $arry[$i] . "</b> votes</td></tr>"; }
		else {
		$table_rows .= "<tr><td>" . $libraries [$i] . " :</td><td><b>" . $arry [$i] . "</b> votes</td></tr>"; }



    }

    require 'results.html.php';

// The “exit;” is used to terminate the script execution after the results have been displayed so that the opinion poll form is not displayed.

    exit;

}

// The “require 'opinion.html.php';” displays the opinion poll form if nothing has been selected.

require 'opinion.html.php';

?>