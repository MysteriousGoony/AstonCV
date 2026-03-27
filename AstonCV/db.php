<?php 
//Connecting database
$host ="localhost";
$dbname = "astoncv";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $status = "connected";
    }
    catch (PDOException $e) {
    $status = "disconnected";
}  
?>
    <!--Making side pop up for this alert to see if DB is connected or disconnected-->
    <div id="Slide_Popup" class="db-status <?php echo $status; ?>">
    <?php echo $status === "connected" ? "Connected" : "Disconnected"; ?>
    </div>
