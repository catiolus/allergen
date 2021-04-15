<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='results.css'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <title>report</title>
</head>
<body>
    <div class="topnav">
        <a href="main.html">Home</a>
        <a href="select.php">Visualize (profilin)</a>
        <a href="select_nsltp.php">Visualize (nsLTP)</a>
        <a href="select_pr10.php">Visualize (pr10)</a>
        <a class="active"  href="personal.php">Inspect</a>
    </div>
    <style>
        body{
            font-family: 'Josefin Sans', sans-serif;
        }
    </style>
    <?php 
        $control = $_POST['control'];
        $nameslist = $_POST['name'];
        $whealslist = $_POST['wheal'];
        $experiences = $_POST['experience'];
        #print_r($nameslist);
        #print_r($whealslist);
        #print_r($experiences);
        #echo "<br>";

        #echo $control;

        $whealname = array();
        $experiencename = array();
        #print_r($nameslist);
        $len = count($whealslist);
        for ($i=0; $i < $len; $i++){
            $whealname[$nameslist[$i]] = $whealslist[$i];
            $experiencename[$nameslist[$i]] = $experiences[$i];

        }
        #print_r($experiencename);
       # print_r($nameslist);
        #echo "<br>";
        #print_r($whealslist);
        #echo "<br>";
        #print_r($whealname);
        #echo "<br>";

        ob_start();
        require "display_nsltp.php";
        ob_end_clean();
        $servername = "localhost";
        $username = "root";
        $password = "Iatwbofm21!";
        $dbname = "crossreactivity";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $removed = array();
        $len = count($_POST['name']);
        for ($i=0; $i < $len; $i++){
            if ($whealslist[$i] - (float)$control >= 3 || $experiences[$i] == 'Yes' || $experiences[$i] == "N/A"){
                $query = "SELECT * FROM crossreactivity_nsltp WHERE origin = '".$nameslist[$i]."'";
                $result = mysqli_query($conn, $query);
                $rows[$i] = mysqli_fetch_all ($result, MYSQLI_ASSOC);
            }else{
                $removed[] = $maps_otn[$nameslist[$i]];
                #echo "not allergic to " . $nameslist[$i];
            }
           
        }
        #echo "<br>";
        #print_r($removed);
        #echo "<br>";
        #print_r($rows);
        $final = array();
       
        foreach($rows as $row){
            foreach($row as $row2){
                foreach($row2 as $key => $value){
                    $final[$key] =0;
                }
            }
        }

        #print_r($final);


        $min = 100000;

        foreach($rows as $row){    
            foreach($row as $row2){
                array_multisort($row2, SORT_DESC, SORT_NUMERIC);
                $origin = $row2['origin'];
                $name = $row2['name'];
                #echo "<br>";
                #print_r($row2);

                unset($row2['origin']);
                unset($row2['name']);

                foreach($row2 as $key => $value){
                    $value = (float)$value;
                    if($value < $min){
                        $min = $value;
                    }
                    if ($value > $final[$key]){
                        $final[$key] = $value;
                        #echo  $final[$key];
                    }
                     #echo $key; 
                }   
                #echo "<br>";
            }
        }
        unset($final['origin']);
        unset($final['name']);


        #echo "<br>";
        ##print_r($removed);
        #echo $min;
        #echo "<br>";
        #print_r($maps);
        foreach ($final as $key => $value){
            for ($k=0; $k < count($removed); $k++){
                if ($key == $removed[$k]){
                    $final[$key] =  $min;
                }   
            }
        }
        

        array_multisort($final, SORT_DESC, SORT_NUMERIC);

        $last = (float)end($final);
        $first = (float)reset($final);
        #echo $last;
        #echo $first;
        #print_r($final);
        foreach($final as $key => $value){
            #echo $value;
            #echo $maps[$key]." : ".$key . " : " . $value . "<br>";   
            /*  
            $cr = (float)$value;
            */
            for ($k=0; $k < count($removed); $k++){
                if ($key == $removed[$k]){
                    $value =  0;
                }   
            }   
            
            $color = numberToColor($value,0,100, ['#8de667', '#fff5f5', '#CC0000']);
            
            echo "<div class='flip-card'>
                    <div class='flip-card-inner'>
                        <div class='flip-card-front'>
                            <div style='padding:10%;display:inline-block; height:80%;width:75%; font-size:28px; color: black; background-color:" . $color . "; text-align:center'>$maps[$key]</div>
                        </div>
                        <div class='flip-card-back'>
                            <h1>$maps[$key]</h1>
                            <p>$key</p>
                            <p>$value</p>
                        </div>
                    </div>
                </div>";
            #echo "<div class = 'result'>$final</div>";
        }
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        $conn->close();
    ?>
    <br>
    <img src="key2.png"> 
    <p>The darker the red, the more you should avoid that substance, the lighter the green, the more ok it is to be around. Flip the cards over to see a risk-score between 0 and 100</p>
    <br>
</body>
    <script type = "text/javascript">
        $( "img" ).each( function() {
            var $img = $( this );
            $img.width( $img.width() * .5 );
        });
    </script>
</html>
