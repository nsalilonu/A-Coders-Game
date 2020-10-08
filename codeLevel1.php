<!DOCTYPE html>
<html>
<?php
    // If the user is visiting this page right after gameplay, they should have 0 mistakes
    $referer = $_SERVER['HTTP_REFERER'];
    
    if (strpos($referer, "gameplay.php")) {
    setcookie("mistakes", "0", 0 , "/");
    setcookie("level", "1", 0, "/");
    }
?>


<head>
    <!-- the next three lines try to discourage browser from keeping page in cache -->
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="cache-control" content="no-store">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3f70d76f1c.js" crossorigin="anonymous"></script>
    <title id="title">  A Coder's Game </title>
</head>

<link href="codeStyle.css" type="text/css" rel="stylesheet" />

<body style="background-color: rgb(0, 0, 0);">
    <pre>
        <p class = "codeLine">1:     </p><p class ="keyword">function </p><p class = "functionName">moveObject</p><p class = "symbol">() {</p> 
        <p class = "codeLine">2:     </p>    <p class ="keyword">const </p><p class = "constant">LEFT</p><p class = "symbol"> = </p><p class = "number">37</p><p class = "symbol">;</p>
        <p class = "codeLine">3:     </p>    <p class ="keyword">const </p><p class = "constant">RIGHT</p><p class = "symbol"> = </p><p class = "number">39</p><p class = "symbol">;</p>
        <p class = "codeLine">4:     </p>    
        <p class = "codeLine">5:     </p>    <p class = "loop">if </p><p class = "symbol">(</p><p class = "variable">event.keyCode</p><p class = "symbol"> == </p><p class = "constant">LEFT</p><p class = "symbol">) {</p>
        <p class = "codeLine">6:     </p>        <p class = "variable">movingLeft</p><p class = "symbol"> = </p><p class = "keyword">true</p><p class = "symbol">;</p>
        <p class = "codeLine">7:     </p>    <p class = "symbol">}</p>
        <p class = "codeLine">8:     </p>    <p class = "loop">else if </p><p class = "symbol">(</p><p class = "variable">event.keyCode</p><p class = "symbol"> == </p><p class = "constant">RIGHT</p><p class = "symbol">) {</p>
        <p class = "codeLine">9:     </p>        <p class = "variable">movingRight</p><p class = "symbol"> = </p><p id = "error1">false</p><p class = "symbol">;</p>
        <p class = "codeLine">10:    </p>    <p class = "symbol">}</p>
        <p class = "codeLine">11:    </p><p class = "symbol">}</p>
        <p class = "codeLine">12:    </p>
        <p class = "codeLine">13:    </p><p class = "keyword">function </p><p class = "functionName">stopMoveObject</p><p class = "symbol">() {</p>
        <p class = "codeLine">14:    </p>    <p class ="keyword">const </p><p class = "constant">LEFT</p><p class = "symbol"> = </p><p class = "number">37</p><p class = "symbol">;</p>     <img id = "sideBanner" src = "Plan B.png">
        <p class = "codeLine">15:    </p>    <p class ="keyword">const </p><p class = "constant">RIGHT</p><p class = "symbol"> = </p><p class = "number">39</p><p class = "symbol">;</p>
        <p class = "codeLine">16:    </p>
        <p class = "codeLine">17:    </p>    <p class = "loop">if </p><p class = "symbol">(</p><p class = "variable">event.keyCode</p><p class = "symbol"> == </p><p class = "constant">LEFT</p><p class = "symbol">) {</p>
        <p class = "codeLine">18:    </p>        <p class = "variable">movingLeft</p><p class = "symbol"> = </p><p class = "keyword">false</p><p class = "symbol">;</p>
        <p class = "codeLine">19:    </p>    <p class = "symbol">}</p>
        <p class = "codeLine">20:    </p>    <p class = "loop">else if </p><p class = "symbol">(</p><p class = "variable">event.keyCode</p><p class = "symbol"> == </p><p class = "constant">RIGHT</p><p class = "symbol">) {</p>
        <p class = "codeLine">21:    </p>        <p class = "variable">movingRight</p><p class = "symbol"> = </p><p class = "keyword">false</p><p class = "symbol">;</p>
        <p class = "codeLine">22:    </p>    <p class = "symbol">}</p>
        <p class = "codeLine">23:    </p><p class = "symbol">}</p>
        <p class = "codeLine">24:    </p>    
        <p class = "codeLine">25:    </p><p class = "keyword">function </p><p class = "functionName">update</p><p class = "symbol">() {</p>
        <p class = "codeLine">26:    </p>    <p class = "variable">ctx</p><p class = "symbol">.</p><p class = "functionName">clearRect</p><p class = "symbol">(</p><p class = "number">0</p><p class = "symbol">, </p><p class = "number">0</p><p class = "symbol">, </p><p class = "variable">canvas</p><p class = "symbol">.</p><p class = "variable">width</p><p class = "symbol">, </p><p class = "variable">canvas</p><p class = "symbol">.</p><p class = "variable">height</p><p class = "symbol">);</p>
        <p class = "codeLine">27:    </p>        
        <p class = "codeLine">28:    </p>    <p class = "loop">if </p><p class = "symbol">(</p><p class = "variable">movingLeft</p><p class = "symbol">) { </p>
        <p class = "codeLine">29:    </p>        <p class = "variable">hero_x</p><p class = "symbol"> -= </p><p id = "error2">0.000000000001</p><p class = "symbol">;</p>
        <p class = "codeLine">30:    </p>    <p class = "symbol">}</p>
        <p class = "codeLine">31:    </p>    
        <p class = "codeLine">32:    </p>    <p class = "loop">if </p><p class = "symbol">(</p><p class = "variable">movingRight</p><p class = "symbol">) {</p>
        <p class = "codeLine">33:    </p>        <p class = "variable">hero_x</p><p class = "symbol"> += </p><p class = "number">6</p><p class = "symbol">;</p>
        <p class = "codeLine">34:    </p>    <p class = "symbol">}</p>
        <p class = "codeLine">35:    </p>    <p class = "variable">ctx</p><p class = "symbol">.</p><p class = "functionName">drawImage</p><p class = "symbol">(</p><p class = "variable">hero</p><p class = "symbol">, </p><p class = "variable">hero_x</p><p class = "symbol">, </p><p class = "variable">hero_y</p><p class = "symbol">);</p>
        <p class = "codeLine">36:    </p><p class = "symbol">}</p>
    </pre>

    <div class = "answerBox"> 
        <span class="close">&times;</span>
        <form action="./answerHandler1.php" method="GET">
            <p class = "answerBoxText"><b>What would you like to replace false with?</b></p>
            <input type = "text" id = "answer1" name = "answer1">
            <input type = "submit" value = "Go!" id = "submitButton">
        </form>
    </div>

    <div class = "answerBox"> 
        <span class="close">&times;</span>
        <form action="./answerHandler1.php" method="GET">
            <p class = "answerBoxText"><b>What would you like to replace 0.000000000001 with?</b></p>
            <input type = "text" id = "answer2" name = "answer2">
            <input type = "submit" value = "Go!" id = "submitButton">
        </form>
    </div>

   
    <?php
    //Check to see if the user has been to this page before. If they have, then they made a mistake.
    if ($_COOKIE["mistakes"] !== "0") {
        echo "<div class = 'errorBox' style = 'display: block;'>";
        //echo "<p1> Mistakes: </p1>".$_COOKIE["mistakes"];
        echo "<span class='close'>&times;</span>";
        echo "<h1 class = 'errorBoxHeader'><b>Oops!</b></h1>";
        echo "<p class = 'answerBoxText'><b>Your magic backfired! Must have been the wrong spell...try again!</b></p>";
        echo "</div>";
    }
    ?>

    <?php 
        // Show the intro if it's the user's first time on the screen.
        if (strpos($referer, "gameplay.php")) {
            echo "<div id='backdrop' style='display:block;'>";
                echo "<div class = 'introBox'>"; 
                    echo "<span class='close'>&times;</span>";
                    echo "<p class = 'answerBoxText'><b>The Backwood Bears have had it with your schemes and plan their revenge!
                        They use their dark magic to unleash chaos, and now you can't move! Don't worry, I've marked where
                        they have been in red. Why didn't I fix it myself? Well, I'm not allowed to directly intervene
                        in these things...Now, now, don't be so mopey about it. How would you like it if I 
                        unmarked the code? No? I thought so... </b></p>";
                    echo "<img src='codeLevel1Intro.png' style='width: 50%;'>";
                echo "</div>";
            echo "</div>";
        }
    ?>
 
    <script type = "module">
        // Message for the first error in the code!
        var error1 = document.getElementById("error1");
        var answerBox1 = document.getElementsByClassName("answerBox")[0];

        error1.addEventListener('click', function() {  answerBox1.style.display = "block";
                                                    });

        // Message for the second error in the code!
        var error2 = document.getElementById("error2");
        var answerBox2 = document.getElementsByClassName("answerBox")[1];
        error2.addEventListener('click', function() {   answerBox2.style.display = "block"; 
                                                    });

        // Close the modal if the user clicks on the 'X'.
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            answerBox1.style.display = "none";
        }

        var span1 = document.getElementsByClassName("close")[1];
        span1.onclick = function() {
            answerBox2.style.display = "none";
        }

        var errorBox = document.getElementsByClassName("errorBox")[0];
        var span2 = document.getElementsByClassName("close")[2];
        if (span2 != undefined && errorBox != undefined) {
            span2.onclick = function() {
                errorBox.style.display = "none";
            }
        }

        // Can only ever have 3 spans, but sometimes it is defined for errorBox and other times it is defined for intro.
        var intro = document.getElementById("backdrop");
        var span3 = document.getElementsByClassName("close")[2];
        if (span3 != undefined && intro != undefined) {
            span3.onclick = function() {
                intro.style.display = "none";
            }
        }

    </script>
</body>

</html>