<!DOCTYPE html>
<html>

<?php
    // Changing the level. 
    if ($_COOKIE["level"] == "1") setcookie("level", "2", 0, "/");
    setcookie("mistakes", "0", 0, "/");
?>


<head>
    <!-- the next three lines try to discourage browser from keeping page in cache -->
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="cache-control" content="no-store">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3f70d76f1c.js" crossorigin="anonymous"></script>
    <title id="title">  A Coder's Game </title>
</head>

<link href="codeStyle.css" type="text/css" rel="stylesheet" />

<body style="background-color: rgb(113, 14, 126);">
    <div class = "endCode">
        <h1 style= "font-size: 40px; font-family: 'Nanum Myeongjo', serif;">Magnificent! You finished Level 1!</h1>
        <p1 style= "font-size: 25px; font-family: 'Indie Flower', cursive;">You can move left again! Lucky for you, you are no more damaged than you left off. 
            Martin was far too busy giving a dramatic evil villian victory speech, and his henchman too busy pretending 
            to listen to him. Yes, pretending... I'm all-knowing in this universe after all, and I'm quite sure I saw Jerry playing Candy 
            Crush Saga under his trench coat in the back. We see you, Jerry. 
            <br>
            <br>
            Anyway, you must go back into the wood. I know, I know, I suppose you want a reward for all your trouble. Look at your "Spells"
            once you're back. You might find something interesting.
            <br>
        </p1>
        <button class ="continue"><b>Continue</b></button>
    </div>

    <canvas id="canvas"></canvas>

    <script type="module">
        var soundtrack = document.createElement("AUDIO");
        soundtrack.src = "coding.mp3";
        soundtrack.loop = true;
        soundtrack.volume = 0.5;

        var canvas = document.getElementById("canvas");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        var ctx = canvas.getContext("2d");

        // Initialize the hero.
        var hero_x = 700;
        var hero_y = 0;
        var hero = new Image();
        var runFrame = 0;
       
        setInterval(function()  { var imgNum = (runFrame % 4) + 1;
                                  hero.src = "Running/run"+imgNum.toString()+".png";
                                  runFrame++;
                                }, 200);

        setInterval(function() {update();}, 10);

        function update() {
            // Clear the canvas.
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(hero, hero_x, hero_y, 200, 200);
        }
    
        window.addEventListener("mouseover", function() {soundtrack.play();});
        var continueGame = document.getElementsByClassName("continue")[0];
        continueGame.addEventListener("click", function() {window.location.href = "./gameplay.php";}, false);
    </script>

</body>
</html>