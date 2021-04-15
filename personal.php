
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='results.css'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="personal.js"></script> --> 
    <title>lets get personal</title>
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
    <form  action = "report.php" method = 'POST'/>
        <br>
        <br>
        <input type="submit" name="submit" value="submit" class = "button">
        <br>
        <br>
        <label for="control">Control</label><br>
        <input autocomplete="off" type ="number" id="control" name="control"> 
        <br>      
        <label for="name"> Food </label>
        <?php
            ob_start();
            require "select_nsltp.php";
            ob_end_clean();
            echo '<input autocomplete="off" type="text" id="name" name="name[]" list="origins">';
            echo '<datalist id="origins" name="name">';
            foreach($menus as $menu){
                $name = $menu['origin'];
                echo "<option value='$name'/>";
            }
            echo "</datalist>";
        ?>
        <datalist id = "exp" name ="experience">
            <option value ='Yes'/>
            <option value ='No'/>
            <option value ='Unknown'/>
        </datalist>
        <label  for="wheal"> Wheal </label>
        <input autocomplete="off"  type="number" id="wheal" name="wheal[]" min = "0" max = "20">
        <label  for="experience">Experience?</label>
        <input type="text" id="experience" name="experience[]"list ="exp">
        
    </form>
    <br>
    <br>
    <button id = "addallergen" class = "button">Add another allergy</button>
    
     
    <script type="text/javascript"> 
        $(function ($) {
            $('body').on("click", '#addallergen', function () {
                $('form').append('<br> <label for="name"> Food </label>')
                $('form').append('<input autocomplete="off" type="text" id="name" name="name[]" list="origins">')
                $('form').append('<label for="name"> Wheal </label>')
                $('form').append('<input autocomplete="off"  type="number" id="wheal" name="wheal[]" min = "0" max = "20">')
                $('form').append('<label  for="reaction"> Experience? </label>');
                $('form').append('<input type="text" id="experience" name="experience[]" list="exp">');
            })
        })(jQuery)

    </script> 
</body>
</html>
 