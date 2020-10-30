<!DOCTYPE html>
<html>

<head>
    <!-- the next three lines try to discourage browser from keeping page in cache -->
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="cache-control" content="no-store">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3f70d76f1c.js" crossorigin="anonymous"></script>
    <title id="title"> Bearly Coding </title>
</head>

<link href="codeStyle.css" type="text/css" rel="stylesheet" />

<body style="background-color: rgb(0, 0, 0);">
    <pre>
        <p class = "codeLine">1:     </p><p class ="keyword">function </p><p class = "functionName">moveObject</p><p class = "symbol">() {</p> 
        <p class = "codeLine">2:     </p>    <p class ="keyword">const </p><p class = "constant">LEFT</p><p class = "symbol"> = </p><p class = "number">37</p><p class = "symbol">;</p>
        <p class = "codeLine">3:     </p>    <p class ="keyword">const </p><p class = "constant">RIGHT</p><p class = "symbol"> = </p><p class = "number">39</p><p class = "symbol">;</p>
        <p class = "codeLine">4:     </p>    
        <p class = "codeLine">5:     </p>    <p class = "loop">if </p><p class = "symbol">(</p><p class = "variable">event.keyCode</p><p class = "symbol"> == </p><p class = "constant">LEFT</p><p class = "symbol">) {</p>
        <p class = "codeLine">6:     </p>        <p class = "variable">movingLeft</p><p class = "symbol"> = </p><p id = "error1">false</p><p class = "symbol">;</p>
        <p class = "codeLine">7:     </p>    <p class = "symbol">}</p>
        <p class = "codeLine">8:     </p>    <p class = "loop">else if </p><p class = "symbol">(</p><p class = "variable">event.keyCode</p><p class = "symbol"> == </p><p class = "constant">RIGHT</p><p class = "symbol">) {</p>
        <p class = "codeLine">9:     </p>        <p class = "variable">movingRight</p><p class = "symbol"> = </p><p class = "keyword">true</p><p class = "symbol">;</p>
        <p class = "codeLine">10:    </p>    <p class = "symbol">}</p>
        <p class = "codeLine">11:    </p><p class = "symbol">}</p>
        <p class = "codeLine">12:    </p>
        <p class = "codeLine">13:    </p><p class = "keyword">function </p><p class = "functionName">stopMoveObject</p><p class = "symbol">() {</p>
        <p class = "codeLine">14:    </p>    <p class ="keyword">const </p><p class = "constant">LEFT</p><p class = "symbol"> = </p><p class = "number">37</p><p class = "symbol">;</p> 
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
        <p class = "codeLine">29:    </p>        <p class = "variable">hero_x</p><p class = "symbol"> -= </p><p class = "number">6</p><p class = "symbol">;</p>
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

    <?php
        // Show the congrats box if the user hasn't made any mistakes.
        if ($_COOKIE["mistakes"] == "0")
        echo "<div id = 'congrats'> ";
        echo "<span class='close'>&times;</span>";
        echo "<p id = 'answerBoxText'><b>Congratulations, your magic has restored your speed to normal! But you still can't move! 
        And yes, I have tried restarting the page...something is still wrong with your source magic...
        What? You don't believe me? Here, let me restart the page again....<br>....<br> There, satisfied? Now get to work!</b> 
        </p>";
        echo "</div>";
   ?>
    <?php
    // Check to see if the user has been to this page before. If they have, then they made a mistake
    if ($_COOKIE["mistakes"] !== "0") {
        echo "<div class = 'errorBox' style = 'display: block;'>";
        //echo "<p1> Mistakes: </p1>".$_COOKIE["mistakes"];
        echo "<span class='close'>&times;</span>";
        echo "<h1 class = 'errorBoxHeader'><b>Oops!</b></h1>";
        echo "<p class = 'answerBoxText'><b>Your magic backfired! Must have been the wrong spell...try again!</b></p>";
        echo "</div>";
    }
    ?>

    <div class="HintBox"> 
        <p1 id="HintBoxText"></p1>
    </div>
   

    <script type = "module">
        var soundtrack = document.createElement("AUDIO");
        soundtrack.src = "coding.mp3";
        soundtrack.loop = true;
        soundtrack.volume = 0.5;

        window.addEventListener("mouseover", function() {soundtrack.play();});

        // Message for the first error in the code!
        var answerBox = document.getElementsByClassName("answerBox")[0];

        // Message for the second error in the code!
        var error1 = document.getElementById("error1");
        error1.addEventListener('click', function() {   
                                                        answerBox.style.display = "block"; 
                                                    });


        // Close the modal if the user clicks on span or out of the answer box.
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
        answerBox.style.display = "none";
        }

        var span1 = document.getElementsByClassName("close")[1];
        var congrats = document.getElementById("congrats");
        span1.onclick = function() {
            congrats.style.display = "none";
        }

        var errorBox = document.getElementsByClassName("errorBox")[0];
        var span2 = document.getElementsByClassName("close")[2];
        if (span2 != undefined) {
            span2.onclick = function() {
                errorBox.style.display = "none";
            }
        }

        // All the explanations for the code -- tears :,(
        var codeLine1 = document.getElementsByClassName("codeLine")[0];
        var codeLine2 = document.getElementsByClassName("codeLine")[1];
        var codeLine3 = document.getElementsByClassName("codeLine")[2];
        var codeLine4 = document.getElementsByClassName("codeLine")[3];
        var codeLine5 = document.getElementsByClassName("codeLine")[4];
        var codeLine6 = document.getElementsByClassName("codeLine")[5];
        var codeLine7 = document.getElementsByClassName("codeLine")[6];
        var codeLine8 = document.getElementsByClassName("codeLine")[7];
        var codeLine9 = document.getElementsByClassName("codeLine")[8];
        var codeLine10 = document.getElementsByClassName("codeLine")[9];
        var codeLine11 = document.getElementsByClassName("codeLine")[10];
        var codeLine12 = document.getElementsByClassName("codeLine")[11];
        var codeLine13 = document.getElementsByClassName("codeLine")[12];
        var codeLine14 = document.getElementsByClassName("codeLine")[13];
        var codeLine15 = document.getElementsByClassName("codeLine")[14];
        var codeLine16 = document.getElementsByClassName("codeLine")[15];
        var codeLine17 = document.getElementsByClassName("codeLine")[16];
        var codeLine18 = document.getElementsByClassName("codeLine")[17];
        var codeLine19 = document.getElementsByClassName("codeLine")[18];
        var codeLine20 = document.getElementsByClassName("codeLine")[19];
        var codeLine21 = document.getElementsByClassName("codeLine")[20];
        var codeLine22 = document.getElementsByClassName("codeLine")[21];
        var codeLine23 = document.getElementsByClassName("codeLine")[22];
        var codeLine24 = document.getElementsByClassName("codeLine")[23];
        var codeLine25 = document.getElementsByClassName("codeLine")[24];
        var codeLine26 = document.getElementsByClassName("codeLine")[25];
        var codeLine27 = document.getElementsByClassName("codeLine")[26];
        var codeLine28 = document.getElementsByClassName("codeLine")[27];
        var codeLine29 = document.getElementsByClassName("codeLine")[28];
        var codeLine30 = document.getElementsByClassName("codeLine")[29];
        var codeLine31 = document.getElementsByClassName("codeLine")[30];
        var codeLine32 = document.getElementsByClassName("codeLine")[31];
        var codeLine33 = document.getElementsByClassName("codeLine")[32];
        var codeLine34 = document.getElementsByClassName("codeLine")[33];
        var codeLine35 = document.getElementsByClassName("codeLine")[34];
        var codeLine36 = document.getElementsByClassName("codeLine")[35];

        
        var hintBox = document.getElementsByClassName("HintBox")[0];
        var hintText = document.getElementById("HintBoxText");
        codeLine1.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is how you begin a function with the name 'moveObject'. Functions perform the 
                                                           commands in the curly braces once you call them. This is the function that makes you move! 
                                                           If only I had something like this for my old roommate...<br>Larry liked to play heavy metal at 12 AM...</b>`});
        codeLine1.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine2.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This line assigns the value '37' to the constant LEFT. 37 is the key code for the left arrow key.
                                                                                And a constant is a value that never changes, unlike my ex-girlfriend, Rose. We grew apart... I'd 
                                                                                rather not talk about it...</b>`});
        codeLine2.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine3.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This line assigns the value '39' to the constant RIGHT. 39 is the key code for the right arrow key.
                                                                                And a constant is, still, a value that never changes...why did she leave me? Was it I who changed?</b>`});
        codeLine3.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine4.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This... is just...a blank line. Seriously? You needed me to tell you that?</b>`});
        codeLine4.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine5.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is an if statement. If the event.keyCode is LEFT, meaning the left arrow key
                                                                                 is being pressed, whatever is in between the curly braces will happen. If only crosswalk signals
                                                                                 were that reliable. I always fear that it's broken, and I'm simply wasting my time.</b>`});
        codeLine5.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine6.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> If the left arrow key is being pressed, movingLeft, what we call a variable, will be set to false. Variables
                                                                                can change, are meant to change. But what if I don't want to change, Rose?! </b>`});
        codeLine6.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine7.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is an closing curly brace. It encloses what is in the if statement. Pretty obvious, but anything is better
                                                                                 than a blank space. I mean, come on? I thought I created intelligent life...</b>`});
        codeLine7.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine8.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b>This is an else if statement. If the if statement is false, meaning event.keyCode is not LEFT, then 
                                                                                 this is checked next. It checks, you guessed it, if the right arrow key is being pressed. It's always
                                                                                 good to have a fallback plan. For example, if you can't fix this...wait...I don't actually have 
                                                                                 a plan for that...no pressure! You're doing swimmingly!`});
        codeLine8.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine9.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> If the right arrow key is being pressed, movingRight, another variable, will be set to true. See how this 
                                                                                else if statement picks up on your signals? Larry would never do that, he'd just chatter on and on and on...
                                                                                what if I want to talk, Larry?! </b>`});
        codeLine9.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine10.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is a closing curly brace for the else if statement. It's not hard...we've been over this... </b>`});
        codeLine10.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine11.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is the closing curly brace for the function moveObject. And thus ends our function! It's called every time you 
                                                                                press a key. But Rose never calls...</b>`});
        codeLine11.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine12.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> You can't be serious...again? We're doing this again?! It's blank! Blank space makes the code...pardon, "magic", easier on the 
                                                                                eyes! Stop obsessing over this!</b>`});
        codeLine12.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine13.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is the beginning of a function called stopMoveObject. As I said before, when called, it will perform
                                                                                whatever is in between the curly braces. It's called whenever a key goes up. Obviously, for this to work you 
                                                                                must first press the key...you cannot activate this function by ripping the keys off your keyboard..</b>`});
        codeLine13.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine14.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Same as before. Saves the keycode for the left arrow key, '37', in a constant called LEFT. Yes, left...
                                                                                just like Rose did...</b>`});
        codeLine14.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine15.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Same as before. Saves the keycode for the right arrow key, '39', in a constant called RIGHT. This is meant
                                                                                to represent the direction, not the moral, or else RIGHT would equal me, your beloved narrator, who is always right.
                                                                                Rose didn't seem to think so? Why, you little...</b>`});
        codeLine15.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine16.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Oh, you must think yourself so clever. "Let's hover over another blank line and see what the narrator will do."
                                                                                Try it again...just try it...</b>`});
        codeLine16.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine17.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is another if statement that checks whether the left arrow key has been lifted. Checking things is important,
                                                                                like checking if we've run out of toilet paper. Larry never seemed to notice...ughhhhh...</b>`});
        codeLine17.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine18.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> If the condition, that is, that the left arrow key has been lifted, is true, then the variable
                                                                                     movingLeft will be set to false. You know why, now, if you've gotten this far, so I won't talk your ear off.</b>`});
        codeLine18.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine19.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> An ending curly brace for your if statement. Provides some finality, doesn't it? Unlike Rose..."I'll call you
                                                                                sometime"?! What does that even mean?!</b>`});
        codeLine19.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine20.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is another else if statement. If the left key hasn't been lifted, it checks whether the right arrow key has been lifted.
                                                                                Because maybe something happened, maybe there's hope, maybe she'll call again...</b>`});
        codeLine20.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine21.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> If the condition is true, that is, the right arrow key has been lifted, then movingRight will be set
                                                                                to false. Then you can stand there with that blank stare as you always do...</b>`});
        codeLine21.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine22.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> An ending curly brace to the end of the else if statement. Are you just paranoid that you'll miss something?
                                                                                You can relax a bit, it's really not that terribly hard to figure out.</b>`});
        codeLine22.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine23.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> An ending curly brace to the end our function. Simple. The curly braces outline what the function has to do 
                                                                                when called, and the function does it! The function doesn't get drunk with his friends and feed the fish
                                                                                Goldfish crackers when his only job was to watch it during my one weekend off. Rest in peace, Marvin.</b>`});
        codeLine23.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine24.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Stop it! Just stop it! It's blank, for crying out loud! There is literally nothing there! Find something
                                                                                better to do with your time besides driving me insane!</b>`});
        codeLine24.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine25.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is the beginning of a function by the name of update. There's a bit of magic not shown
                                                                                here that calls it every 10 milliseconds. Quite a lot of updates, huh? Well, far better than none 
                                                                                at all. The pizza delivery man never comes when he says he will, but as soon as I go to the 
                                                                                toilet he manages to appear out of thin air! So much for modernity...</b>`});
        codeLine25.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine26.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This clears the canvas, which is the world that you're in. This may sound alarming.
                                                                                But don't worry, in a few lines you are magicked back into existence 
                                                                                again. I have to clear the world so you can be put in a new position if you moved. Without this, 
                                                                                there would be a still version of you in every position that you've ever been. 
                                                                                Far more alarming, isn't it? I still get nightmares...</b>`});
        codeLine26.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine27.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> What do you want? Are you hoping for some sort of treasure? A jackpot, of
                                                                                sorts? You accomplish nothing by doing this! A blank line is a blank line!</b>`});
        codeLine27.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine28.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This is an if statement. If movingLeft is true, then it will run the commands
                                                                                in between the curly braces. You could also have if(movingLeft == true), which
                                                                                accomplishes the same thing, but that's a waste of space. Just like Larry's 
                                                                                drumset. The man had no rhythm, and one night the cat must have upset it, because
                                                                                the cymbal crashed in the middle of the night. I nearly had a stroke...</b>`});
        codeLine28.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine29.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> If the condition in the if statement is true, then your horizontal position, hero_x,
                                                                                will be subtracted by 6, an appreciable distance. Perhaps this can be likened to the 
                                                                                moment you realize you didn't hit snooze, but turned your alarm off. Nearly got 
                                                                                fired that time, I had to bring the whole team donuts to smooth things over.</b>`});
        codeLine29.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine30.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> An ending curly brace for an ending if statement. You should always finish what you 
                                                                                started. For example, Mr. Handyman, you should not start to make renovations on my
                                                                                front porch and reschedule for 3 months in a row! What am I supposed to do with these
                                                                                gaping holes?! It was better before!</b>`});
        codeLine30.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine31.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Dancing queen, young and sweet, only 17, yeah yeah! You can dance! You can jiiiIIIVE! Having
                                                                                    the time of your liiiife, OOOOOooo. See that girl! Watch that scene! Digging the dancing queen!
                                                                                    Is that what you wanted? Because my own mortification is the only fathomable purpose I can
                                                                                    see in your insistence on seeking explanations for BLANK LINES!</b>`});
        codeLine31.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine32.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Another if statement. If movingRight is true, it runs the commands in the curly braces. A police
                                                                                officer would perform given commands in the opposite case, where you're moving in the wrong
                                                                                direction. But sometimes one-way signs aren't terribly obvious, OK? I'm a good driver!</b>`});
        codeLine32.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine33.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This line will run if movingRight is true. It moves you in the right direction at a healthy
                                                                                6 paces! And...straight into the bear's grasp. This might be desirable in some situations, to 
                                                                                meet danger head-on, but luckily you can retreat at an equal pace! I'm afraid I couldn't do the
                                                                                same, I'm quite out of shape. Is that why she left me?</b>`});
        codeLine33.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine34.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> You end an if statement with a curly brace. Nothing new. But sometimes things don't always go as expected.
                                                                                You think you've closed a chapter, but then your mother won't stop going on about how you need to get married;
                                                                                get back on the saddle. I have my own life! Stay out of it!`});
        codeLine34.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine35.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> This draws you in the world at your new position. It's a fresh start, a new chance. But what if you liked
                                                                                the way things were? Dating is so hard to get into again. Rose was perfect, how could I ever love anyone else?`});
        codeLine35.addEventListener("mouseout", function() {hintBox.style.display = "none";});
        codeLine36.addEventListener("mouseover", function() {hintBox.style.display = "block";
                                                           hintText.innerHTML = `<b> Here we are, at the end! A final ending curly brace to end the update function. That should be all you need to figure out 
                                                                                your errors. Huh, what else do you need? A foot massage? Who do you think you are, the Queen of England? Get back to work!`});
        codeLine36.addEventListener("mouseout", function() {hintBox.style.display = "none";});

    </script>
</body>

</html>