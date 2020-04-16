<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test :3</title>
</head>
<body>
    
<?php

    include "Competitor.php";
    include "Team.php";

    $team = new Team(); 
    
    $team->add_competitor(new Competitor("Loquendo", "Pepe", "Pepudo","234231","pepsi@setup.es"));
    $team->add_competitor(new Competitor("Nako", "Pepa", "Pepuda","4321","nako123@setup.es"));
    $team->add_competitor(new Competitor("Moledor", "Lola", "Loluda","671","lola@setup.es"));

    $team->echo_team();

?>

</body>
</html>