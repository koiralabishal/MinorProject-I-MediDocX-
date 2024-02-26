<?php



include 'connection.php';



$patientName = $_GET['patientName'];
$patientID = $_GET['patientID'];
$doctorID = $_GET['doctorID'];


$sql = "SELECT t.category , t.testNames,  t.patientName , h.name FROM test_data t INNER JOIN hospital h ON t.doctorID = h. doctorID WHERE t.patientID = $patientID AND t.doctorID = $doctorID";
$result = mysqli_query ($conn, $sql);



if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "Patient Name: " . $row['patientName'] . "<br />";
    echo "Patient ID: " . $patientID . "<br />";
    echo "Referred By: Dr. " . $row['name'] . "<br />. <br />";

    $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
    $category =  $row['category'];
    echo "Category: " . $category . "<br />";
   
    echo "Test Names: <br />";
    for ($i = 0; $i < count($testNames); $i++) {
        $testNameVariable = "testName" . ($i + 1) . ": " . $testNames[$i]. "<br />"; // Dynamically create variable names
        
        echo $testNameVariable;
       
    }
    echo "<br />";
    while ($row = mysqli_fetch_assoc($result)) {
        $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
        // echo $testNames;
        echo "Category: " . $row['category'] . "<br />";
       
        echo "Test Names: <br />";
        for ($i = 0; $i < count($testNames); $i++) {
            $testNameVariable = "testName" . ($i + 1) . ": " . $testNames[$i]. "<br />"; // Dynamically create variable names
            
            echo $testNameVariable;
            
        }
        echo "<br />";

      
    }
}
