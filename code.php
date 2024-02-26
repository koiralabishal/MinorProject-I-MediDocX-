<?php



// include 'connection.php';



// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $doctorID = $_GET['doctorID'];


// $sql = "SELECT t.category , t.testNames,  t.patientName , h.name FROM test_data t INNER JOIN hospital h ON t.doctorID = h. doctorID WHERE t.patientID = $patientID AND t.doctorID = $doctorID";
// $result = mysqli_query ($conn, $sql);



// if ($result) {
//     $row = mysqli_fetch_assoc($result);
//     echo "Patient Name: " . $row['patientName'] . "<br />";
//     echo "Patient ID: " . $patientID . "<br />";
//     echo "Referred By: Dr. " . $row['name'] . "<br />. <br />";

//     $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
//     echo "<table border='1'>";
//     echo "<tr><th>Category</th><th>Test Name</th></tr>";
//     $category =  $row['category'];
//     echo  "<tr><td>". $category . "</tr> </td>";

//     // echo "Test Names: <br />";
//     for ($i = 0; $i < count($testNames); $i++) {
//         $testNameVariable =  $testNames[$i]; // Dynamically create variable names

//         echo "<tr><td>".$testNameVariable. "</tr></td>";

//     }
//     echo "<br />";
//     while ($row = mysqli_fetch_assoc($result)) {
//         $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
//         // echo $testNames;
//         // echo "Category: " . $row['category'] . "<br />";

//        echo  "<tr><td>". $row['category'] . "</tr> </td>";
//         echo "Test Names: <br />";
//         for ($i = 0; $i < count($testNames); $i++) {
//             $testNameVariable = "testName" . ($i + 1) . ": " . $testNames[$i]. "<br />"; // Dynamically create variable names

//             echo $testNameVariable;

//         }
//         echo "<br />";


//     }






include 'connection.php';



$patientName = $_GET['patientName'];
$patientID = $_GET['patientID'];
$doctorID = $_GET['doctorID'];


$sql = "SELECT t.category , t.testNames,  t.patientName , h.name FROM test_data t INNER JOIN hospital h ON t.doctorID = h. doctorID WHERE t.patientID = $patientID AND t.doctorID = $doctorID";
$result = mysqli_query($conn, $sql);



if ($result) {

    echo "<html>";
    echo "<head>";
    echo "<style>";
    echo "table {";
    echo "    width: 50%;";
    echo "    border-collapse: collapse;";
    echo "}";
    echo "th, td {";
    echo "    border: 1px solid black;";
    echo "    padding: 8px;";
    echo "}";
    echo "th {";
    echo "    text-align: left;";
    echo "}";
    echo "</style>";
    echo "</head>";
    echo "<body>";


    $row = mysqli_fetch_assoc($result);
    echo "</br />";
    echo "<h2 align = 'center'>" . "Patient Name: " . $row['patientName'] . "</h2>";
    echo "<h2 align = 'center'>" . "Patient ID: " . $patientID . "</h2>";
    echo "<h2 align = 'center'>" . "Referred By: Dr. " . $row['name'] . "</h2>" . "<br />";

    $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
    echo "<table border='1' align= center>";
    echo "<tr><th>Category</th><th>Test Name</th></tr>";
    $category = $row['category'];
    echo "<tr><th rowspan='" . (count($testNames) + 1) . "'>" . $category . "</tr> </th>";

    // echo "Test Names: <br />";
    for ($i = 0; $i < count($testNames); $i++) {
        $testNameVariable = $testNames[$i]; // Dynamically create variable names

        echo "<tr><td>" . $testNameVariable . "</tr></td>";

    }
    echo "<br />";
    while ($row = mysqli_fetch_assoc($result)) {
        $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
        // echo $testNames;
        // echo "Category: " . $row['category'] . "<br />";

        echo "<tr><th rowspan='" . (count($testNames) + 1) . "'>" . $row['category'] . "</tr> </th>";
        // echo "Test Names: <br />";
        for ($i = 0; $i < count($testNames); $i++) {
            $testNameVariable = $testNames[$i]; // Dynamically create variable names

            echo "<tr><td>" . $testNameVariable . "</td></tr>";

        }
        // echo "<br />";


    }
    
}

// }

// // include 'connection.php';

// // $patientName = $_GET['patientName'];
// // $patientID = $_GET['patientID'];
// // $doctorID = $_GET['doctorID'];

// // $sql = "SELECT t.category, t.testNames, t.patientName, h.name 
// //         FROM test_data t 
// //         INNER JOIN hospital h ON t.doctorID = h.doctorID 
// //         WHERE t.patientID = $patientID AND t.doctorID = $doctorID";
// // $result = mysqli_query($conn, $sql);

// // if ($result) {
// //     echo "<table border='1' align = 'center'>";
// //     echo "<tr><th>Category</th><th>Test Names</th></tr>";

// //     while ($row = mysqli_fetch_assoc($result)) {
// //         $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
// //         $category = $row['category'];

// //         // Output Category and Test Names in separate columns
// //         echo "<tr>";
// //         echo "<td rowspan='" . (count($testNames) + 1) . "'>" . $category . "</td>"; // rowspan for Biochemistry
// //         echo "</tr>";

// //         // Output each Test Name in separate rows within the Test Names column
// //         foreach ($testNames as $testName) {
// //             echo "<tr>";
// //             echo "<td>" . $testName . "</td>";
// //             echo "</tr>";
// //         }
// //     }

// //     echo "</table>";
// // } else {
// //     echo "No records found";
// // }

// include 'connection.php';

// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $doctorID = $_GET['doctorID'];

// $sql = "SELECT t.category, t.testNames, t.patientName, h.name 
//         FROM test_data t 
//         INNER JOIN hospital h ON t.doctorID = h.doctorID 
//         WHERE t.patientID = $patientID AND t.doctorID = $doctorID";
// $result = mysqli_query($conn, $sql);

// if ($result) {
//     // echo "<table border='1' align = 'center'>";
//     // echo "<tr><th>Category</th><th>Test Names</th></tr>";

//     while ($row = mysqli_fetch_assoc($result)) {
//         $testNames = explode(', ', $row['testNames']); // Split testNames by comma and space
//         $category = $row['category'];
//         echo $category. "</br />";
//         // Output Category and Test Names in separate columns
//         // echo "<tr>";
//         // echo "<td rowspan='" . (count($testNames) + 1) . "'>" . $category . "</td>"; // rowspan for Biochemistry
//         // echo "</tr>";

//         // Output each Test Name in separate rows within the Test Names column
//         foreach ($testNames as $testName) {
//             // echo "<tr>";
//             // echo "<td>" . $testName . "</td>";
//             echo  $testName. "</br />" ;
//             // echo "</tr>";
//         }
//     }

//     // echo "</table>";
// } else {
//     echo "No records found";
// }
