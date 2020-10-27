<!DOCTYPE html>
<html>
<?php 
        $referer = $_SERVER['HTTP_REFERER'];
        if (isset($_COOKIE["level"]) && strpos($referer, "codeLevel1End.php")) {
            echo "<p1 id= 'level'>Level ".$_COOKIE["level"]."</p1>";
        }
        else {
            setcookie("level", "1", 0, "/");
            echo "<p1 id= 'level'>Level 1</p1>";
        }
        setcookie("mistakes", "0", 0, "/");

        if (isset($_COOKIE["intro"]) && strpos($referer, "intro.php"))
        echo "<p1 id='introset' style='display:none;'>complete</p1>"; // When you have completed the intro, only show quick info
        else 
        echo "<p1 id='introset' style='display:none;'>incomplete</p1>"; // When you haven't, redirect user to the intro page.
?>


<head>
    <!-- the next three lines try to discourage browser from keeping page in cache -->
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="cache-control" content="no-store">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3f70d76f1c.js" crossorigin="anonymous"></script>
    <title id="title">  A Coder's Game </title>
</head>


<link href="style.css" type="text/css" rel="stylesheet" />

<body style="background-color: rgb(226, 113, 147);">


    <p1 id= "time">Points: 0</p1>
    <p1 id= "health">Health:</p1>
    <div id= "progress"></div>
    <div id= "bar"></div>
    <div id= "endGameBack">
        <div id= "endGameFront">
            <p id= "endGameTxt"><b>Oh my...you are not looking well. No, no, not in that way. You're very pretty, but you're also,
                well, dead...My fault? Don't be preposterous, I already told you, my hands are tied! The rules and regulations that 
                come with being a creator forbid me to...Come on, don't yell...OK, OK! There's one thing I can do...here! A restart 
                button. Yes, you'll lose all your points, but you'll get your health back! And that's all you're getting out of me!
            </b></p>
        </div>
        <button id="restart">Restart?</button>
    </div>
    
    <i class="fas fa-pause" id="pauseButton"></i>
    <i class="fas fa-play" id="playButton"></i>
    <div id = "spells">
        <p1>Spells</p1>
        <br>
        <table>
            <td>
                <img src="icon1.png" id = "spell1" style="height:100px; width: 100px; border-radius: 6px; display: none;">
                <img src="icon1.png" id = "spell1Select" style="height:100px; width: 100px; border-radius: 6px; border: 3px solid black;"> 
            </td>
            <td>
                <img src="icon2.png" id = "spell2" style="height:100px; width: 100px; border-radius: 6px; display: none;">
                <img src="icon2.png" id = "spell2Select" style="height:100px; width: 100px; border-radius: 6px; border: 3px solid black; display: none;">
            </td>
        </table>
    </div>

    <div id="pauseBox">
        Ahh, taking a break now, are we? That's ok, there's no rush. It's not like the world as you know
        it may come to an end if you don't do something about the Backwood Bear gang. I'm sure they'll 
        just tire themselves out as you prioritize your "self-care".
        <br>
        Well, while you're here, I may as well offer you a few things to do...
        <br>
        <button id="save"><b>Save</b></button>
        <button id="gameplayIntro"><b>How to Play</b></button>
        <button id="saveExit"><b>Save and Exit</b></button>
    </div>

    <div id="infoBox">
        <span class="close">&times;</span>
        <p1>
        Well, you've heard my intro, so I'll give you the highlights...
        <br>
        <b>Move:</b> Use the arrow keys. You know, the ones that explicitly indicate direction? 
        <br>
        <b>Select Spells:</b> <p1 style="color: red;">Shift.</p1> Don't press it too many times! You'll get Sticky Keys. Who in the world invented that? No one ever
        intends to invoke this mysterious command.
        <br>
        That's it. You wouldn't think it would be too hard to remember, but perhaps the bears have knocked you over one too many times...
        </p1>
    </div>



    <canvas id="canvas"></canvas>

    <script type="module">
        var seconds = 0;
        var bar_width = 330;
        
        var canvas = document.getElementById("canvas");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        var ctx = canvas.getContext("2d");

        // Initialize the hero.
        var hero_x = 10;
        var hero_y = canvas.height/12 + 440;
        var hero = new Image();
        hero.src = "Tiger Walking/tiger5.png";


        var background = new Image();
        background.src = "Background1.png";
        var background_x = -700;
        var background_y = 0;
        var foreground = new Image();
        foreground.src = "foreground.png";
        

        var back_background = new Image();
        back_background.src = "Back_Background.png";

        var clouds = new Image();
        clouds.src = "Clouds.png";
        var clouds_x = -1000;
        ctx.drawImage(back_background, 0, 0);
        ctx.drawImage(clouds, clouds_x, 0);
        ctx.drawImage(background, background_x , background_y);


        var soundtrack = document.createElement("AUDIO");
        soundtrack.src = "soundtrack.mp3";
        soundtrack.loop = true;
        soundtrack.volume = 0.5;
        window.addEventListener("mouseover", function() {soundtrack.play();});
        
        // Update the canvas every 10 milliseconds.
        var interval = setInterval(function () {update(); }, 10);

        // Respond to different keyboard presses.
        window.addEventListener('keydown', moveObject, false);
        window.addEventListener('keyup', stopMoveObject, false);
        window.addEventListener('keypress', bearHit, false);

        var muted = document.getElementById("muted");
        var sound = document.getElementById("volume-on");
        var pauseButton = document.getElementById("pauseButton");
        var playButton = document.getElementById("playButton");
        var restart = document.getElementById("restart");
        var spellBox = document.getElementById("spells");
        var spell1 = document.getElementById("spell1");
        var spell1Select = document.getElementById("spell1Select");
        var spell2 = document.getElementById("spell2");
        var spell2Select = document.getElementById("spell2Select");
        var level = document.getElementById("level");
        var pauseBox = document.getElementById("pauseBox");
        var gameplayIntro = document.getElementById("gameplayIntro");
        var introset = document.getElementById("introset");
        var infoBox = document.getElementById("infoBox");
        var spellSelected = 1;


        // Pause or unpause the game.
        pauseButton.addEventListener('click', function(){   pause = true;
                                                            pauseButton.style.display = "none";
                                                            playButton.style.display = "block";
                                                            pauseBox.style.display = "block";
                                                        });
                                                            // Pause or unpause the game.
        playButton.addEventListener('click', function(){    pause = false;
                                                            pauseButton.style.display = "block";
                                                            playButton.style.display = "none";
                                                            pauseBox.style.display = "none";
                                                            infoBox.style.display = "none";
                                                       });
        // Reload the page in the event that the user loses and wants to restart.
        restart.addEventListener('click', function() {location.reload();});

        // Go to the intro or show Quick Info depending on the cookie when the player clicks "How to Play"
        gameplayIntro.addEventListener('click', function() {    if (introset.innerHTML == "complete") {
                                                                    infoBox.style.display = "block";
                                                                    pauseBox.style.display = "none";
                                                                }
                                                                else if (introset.innerHTML == "incomplete") {
                                                                    window.location.href = "./intro.php";
                                                                }
                                                            });
        // Close the modal if the user clicks on the 'X'.
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            infoBox.style.display = "none";
            pauseBox.style.display = "block";
        }

        // Handle the spells.
        if (level.innerHTML.includes("Level 2")) spell2.style.display = "block";
        spell1.addEventListener('click', function() {   spell1Select.style.display = "block";
                                                        spell1.style.display = "none";
                                                        spell2Select.style.display = "none";
                                                        spell2.style.display = "block";
                                                        spellSelected = 1;
                                                    });
        spell2.addEventListener('click', function() {   spell2Select.style.display = "block";
                                                        spell2.style.display = "none";
                                                        spell1Select.style.display = "none";
                                                        spell1.style.display = "block";
                                                        spellSelected = 2;
                                                    });

        // The amount of time that the user has survived.
        var clock = setInterval(function() {    if (!pause) { 
                                                    var points = document.getElementById("time");
                                                    seconds++;
                                                    points.innerHTML = "Points:      " + seconds;
                                                }     
                                           }, 1000);

        // Add an enemy every 5 seconds.
        var enemyClock = setInterval(function() {if (!pause) enemyInit(canvas);}, 8000);

        // Switch to the coding HTML page after 10 seconds (will obviously be longer in the actual game).
        setTimeout(function() {if (level.innerHTML.includes("Level 1")) window.location.href = "./codeLevel1.php";}, 60000);
        var level = document.getElementById("level");
        setTimeout(function() { level.style.display = "none";}, 5000);

        // Initialize other variables.
        var enemyList = [];
        let movingLeft = false;
        let movingRight = false;
        let startWalk = false;
        let startJump = false;
        var jumpFrame = 0;
        let walkFrame = 0;
        var startAttack = false;
        let attackFrame = 0;
        var firstHit = false;
        var dying = false;
        var pause = false;

        var walkingInterval;        
        var jumpInterval; 
        var heroAttack;
        var walking = document.createElement("AUDIO");
        walking.src = "footstep.mp3";
        walking.volume = 0.2;
        walking.playbackRate = 1.9;

        function enemyInit(canvas) {
            // Only have 10 images in the array at a time.
            if (enemyList.length < 10) {
                var enemy = new Image();
                enemy.src = "Enemy Walking/enemy5.png";
                

                // Put the enemy in a random place off the canvas.
                var random = Math.random()*100;
                var enemy_x = canvas.width + random; // Where the enemy appears on the canvas.
                var enemy_y = canvas.height/12 + 440;
                var enemy_hit = 0;  // How long the enemy has been hit for
                var enemyFrame = 0; // The different frames for the enemy walk
                var hitFrame = 0; // The different frames for when the enemy is hit.
                var hitNum = 0; // The amount of times the enemy has been hit.
                var enemyDown = 0; // The amount of time the enemy has been defeated for.
                var bearInterval; // The interval for all bear animations.
                bearInterval = setInterval(function() { if (!pause) {
                                                            var imgNum = (enemyFrame % 4) + 1;
                                                            enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                            enemyFrame++; 
                                                        }
                                                      }, 200);
                enemyList.push({enemy: enemy, enemy_x: enemy_x, enemy_y: enemy_y, 
                enemy_hit: enemy_hit, hitFrame: hitFrame, hitNum: hitNum, 
                enemyDown: enemyDown, bearInterval: bearInterval});
            }

            // If we have 10 images in the array and an enemy has been down for 20 s, 
            // make visible a defeated enemy.
            else {
                for (let i = 0; i < enemyList.length; i++) {
                    if (enemyList[i].enemyDown > 50) {
                        clearInterval(enemyList[i].bearInterval);
                        enemyList[i].enemy.src = "Enemy Walking/enemy5.png";
                        var enemyFrame = 1;
                        enemyList[i].bearInterval = setInterval(function() { if (!pause) {
                                                                                var imgNum = (enemyFrame % 4) + 1;
                                                                                enemyList[i].enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                                                enemyFrame++; 
                                                                             }
                                                                           }, 200);
                        var random = Math.random()*100;
                        enemyList[i].enemy_x = canvas.width + random;
                        enemyList[i].enemy_y = canvas.height/12 + 440;
                        enemyList[i].hitNum = 0;
                        enemyList[i].hitFrame = 0;
                        enemyList[i].enemy_hit = 0;
                        enemyList[i].enemyDown = 0;
                        break;
                    }
                }
            }
        }

        function moveObject() {
            const LEFT = 37;
            const RIGHT = 39;
            const UP = 38;
            const SHIFT = 16;

            if (event.keyCode == LEFT && !dying && !pause) {
                movingLeft = true;
                runLeft();
            } 
            else if (event.keyCode == RIGHT && !dying && !pause) {
                movingRight = true;
                runRight();
            }
            else if (event.keyCode == UP && !dying && !pause) {
                jumpUp();
            }
            if (event.keyCode == SHIFT && !pause) {
                spellBox.style.display = "block";
                pause = true;
            }
            else if (event.keyCode == SHIFT && pause) {
                spellBox.style.display = "none";
                pause = false;
            }
        }

        function bearHit() {
            if (dying || pause) return;

            const SPACEBAR = 32;
            if (event.keyCode == SPACEBAR) {
               
                if (!startAttack && !dying){
                    clearInterval(walkingInterval);
                    startWalk = false;
                    heroAttack = setInterval(function() {   //var imgNum = (attackFrame % 7) + 1;
                                                            var imgNum = 7;
                                                            if (movingLeft || hero.src.includes("tiger5.png") || hero.src.includes("LTigerAttack")) 
                                                                hero.src = "Tiger Attack/LTigerAttack" + imgNum.toString() +".png";
                                                            else 
                                                                hero.src = "Tiger Attack/RTigerAttack" + imgNum.toString() +".png";
                                                            //attackFrame++;
                                                            
                                                        }, 100);
                                                        
                    
                    setTimeout(function() { clearInterval(heroAttack);
                                            attackFrame = 0;
                                            walkFrame = 0;
                                            startAttack = false;
                                            if (hero.src.includes("RTigerAttack") && (!movingLeft && !movingRight))
                                                hero.src = "Tiger Walking/tiger6.png";  
                                            else if (hero.src.includes("LTigerAttack") && (!movingLeft && !movingRight))
                                                hero.src = "Tiger Walking/tiger5.png"; 
                                            else if (movingRight) {
                                                hero.src = "Tiger Walking/tiger10.png";
                                                runRight(); 
                                            }
                                            else if (movingLeft) {
                                                hero.src = "Tiger Walking/tiger4.png";
                                                runLeft();
                                            } 
                                            
                                        }, 500);
                    startAttack = true;
                }

                // Make bear fall back if hero hits it.
                var closestBear;
                var closest = 400;
                var closestBearFound = false;
                for (let i = 0; i < enemyList.length; i++) {
                    if (!enemyList[i].enemy.src.includes("transform")) {
                        // Look for the closest bear.
                        if (Math.abs(hero_x - enemyList[i].enemy_x) < closest) {
                            closest = Math.abs(hero_x - enemyList[i].enemy_x);
                            closestBearFound = true;
                            closestBear = i;
                        }
                    }
                }

                // Run animation for bear and move it back if it is the closest to the tiger when spacebar is pressed.
                // And make sure the user isn't holding spacebar by only setting the interval after 100 ms from when the spacebar was pressed.
                // AND make sure the user is facing the bear it wants to hit.
                
                if (closestBearFound && !firstHit && !dying && hero.src.includes("RTigerAttack")) {
                enemyList[closestBear].enemy_hit = 0;
                enemyList[closestBear].hitFrame = 0;
                clearInterval(enemyList[closestBear].bearInterval); // Stops previous animation
                enemyList[closestBear].bearInterval = setInterval(function (){   if (enemyList[closestBear].hitFrame < 3) {
                                                                            var imgNum = (enemyList[closestBear].hitFrame % 3) + 1;
                                                                            enemyList[closestBear].enemy.src = "Enemy Hit/enemyhit" + imgNum.toString() + ".png";
                                                                            enemyList[closestBear].enemy_x += 100;
                                                                            enemyList[closestBear].hitFrame++;
                                                                            }
                                                                            else
                                                                                enemyList[closestBear].enemy.src = "Enemy Hit/enemyhit3.png";

                                                                            enemyList[closestBear].enemy_hit++;
                                                                        }, 100);
                enemyList[closestBear].hitNum++;
                firstHit = true;
                }
                            
            }
        }

        function runLeft() {
            // Change image every 0.5 second when button is first pressed down.
            if (!startWalk && !startAttack && !dying && !pause && jumpFrame == 0) { 
                walkingInterval = setInterval(function(){   var imgNum = (walkFrame % 4) + 1;
                                                            hero.src = "Tiger Walking/tiger" + imgNum.toString() + ".png";
                                                            walkFrame++;
                                                            if (imgNum % 2 == 0) walking.play();
                                                        }, 150);
                startWalk = true; 
            }
        }

        function runRight() {
            // Change image every 0.5 second when button is first pressed down.
            if (!startWalk && !startAttack && !dying && !startJump && !pause && jumpFrame == 0) {
                walkingInterval = setInterval(function(){   var imgNum = (walkFrame % 4) + 7;
                                                            hero.src = "Tiger Walking/tiger" + imgNum.toString() + ".png";
                                                            walkFrame++;
                                                            if (imgNum % 2 == 0) walking.play();
                                                        }, 150);
                startWalk = true;
            } 
        }

        // Sets the animation for the tiger jump during gameplay.
        function jumpUp() {
            // Makes sure that you only set the interval once.
            if (!dying && !pause && jumpFrame == 0) {
                if (jumpInterval != undefined) clearInterval(jumpInterval);
                jumpInterval = setInterval(function() { jumpFrame++;
                                                        if (jumpFrame < 2) {
                                                            if (movingLeft || hero.src.includes("tiger5.png") || hero.src.includes("LTigerAttack") || 
                                                            hero.src.includes("TigerJump4"))
                                                                hero.src = "Tiger Jump/TigerJump4.png";
                                                            else 
                                                                hero.src = "Tiger Jump/TigerJump1.png"; 
                                                        }
                                                        else {
                                                            if (movingLeft ||  hero.src.includes("TigerJump4") || hero.src.includes("TigerJump5"))
                                                                hero.src = "Tiger Jump/TigerJump5.png";
                                                            else
                                                                hero.src = "Tiger Jump/TigerJump2.png" 
                                                        }
                                                        
                                                    }, 150);
                }     
            }

        // Stops moving if keyup.
        function stopMoveObject() {
            if (dying || pause) return;

            const LEFT = 37;
            const RIGHT = 39;
            const SPACEBAR = 32;

            if (event.keyCode == LEFT) {
                movingLeft = false;
                startWalk = false;
                clearInterval(walkingInterval); // Stop walking animation
                walkFrame = 0;
                if (!startAttack) hero.src = "Tiger Walking/tiger5.png"; // Stationary avatar looking left 
            }
            else if (event.keyCode == RIGHT) {
                movingRight = false;
                startWalk = false;
                clearInterval(walkingInterval); // Stop walking animation
                walkFrame = 0;
                if (!startAttack) hero.src = "Tiger Walking/tiger6.png"; // Stationary avatar looking right
            }

            if (event.keyCode == SPACEBAR) {
                firstHit = false;
            }
        }

        function update() {
            // Clear the canvas.
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Move the enemy, change the background.
            background.src = "Background1.png";
            for (let i = 0; i < enemyList.length; i++) {
                // Spell 1 animation.
                if (enemyList[i].hitNum >= 3 && enemyList[i].enemyDown == 0 && !pause)  {
                    var points = document.getElementById("time");
                    seconds += 100;
                    points.innerHTML = "Points: "+ seconds;
                    
                    clearInterval(enemyList[i].bearInterval);
                    enemyList[i].hitNum = 0;
                    var enemyFrame = 0;
                    var spellStarted = false;
                    
                    if (spellSelected == 1) {
                    enemyList[i].bearInterval = setInterval(function(){ if (!pause) {
                                                                            var imgNum = (enemyFrame % 18) + 1;
                                                                            enemyList[i].enemy.src = "Spell 1/transform" + imgNum.toString() + ".png";
                                                                            enemyFrame++;
                                                                            if (enemyFrame == 18) {
                                                                                enemyFrame = 15; // Loop the flapping animation.
                                                                            }
                                                                            enemyList[i].enemyDown++;
                                                                            if (enemyFrame >= 15)
                                                                            enemyList[i].enemy_y-=100; // Start going up!
                                                                            }
                                                                      }, 200);
                    }
                    else if (spellSelected == 2) {
                        enemyList[i].bearInterval = setInterval(function(){ if (!pause) {
                                                                                var imgNum = (enemyFrame % 11) + 1;
                                                                                enemyList[i].enemy.src = "Spell 2/transform" + imgNum.toString() + ".png";
                                                                                enemyFrame++;
                                                                                if (enemyFrame == 11) {
                                                                                    enemyFrame = 7; // Loop the walking in shame animation.
                                                                                }
                                                                                enemyList[i].enemyDown++;
                                                                                if (enemyFrame >= 7)
                                                                                enemyList[i].enemy_x+=50; // Start walking right!
                                                                            }
                                                                        }, 200);
                    }
                }
                if (!enemyList[i].enemy.src.includes("transform")) {
                    if (enemyList[i].enemy_hit == 0 && !pause) 
                        enemyList[i].enemy_x -=5;
                        // Stop enemy from moving after hit for two seconds.
                    else if (enemyList[i].enemy_hit >= 10) {
                        enemyList[i].enemy_hit = 0;
                        clearInterval(enemyList[i].bearInterval);
                        var enemyFrame = 0;
                        enemyList[i].hitFrame = 0;
                        enemyList[i].bearInterval = setInterval(function(){ if (!pause) {   
                                                                            var imgNum = (enemyFrame % 4) + 1;
                                                                            enemyList[i].enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                                            enemyFrame++; 
                                                                          }
                                                                        }, 200);
                    }
                    var random = Math.random()*1000;
                    if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                    if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;        
                }
            }

            if (movingLeft && !dying && !pause) {
                hero_x-=4;
                background_x+=4;
                if (hero_x < 0) hero_x = 0; // Keep avatar in bounds
                if (background_x > 0) background_x = -1360; // Scroll background.
                for (let i = 0; i < enemyList.length; i++) {
                        enemyList[i].enemy_x+=4;
                        var random = Math.random()*1000;
                        if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                        if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;
                    
                }
            }
            if (movingRight && !dying && !pause) {
                hero_x+=4;
                background_x-=4;
                if (hero_x > canvas.width - 400) hero_x = canvas.width - 400;
                if (background_x < -1360) background_x = 0; // Scroll background.
                for (let i = 0; i < enemyList.length; i++) {
                        enemyList[i].enemy_x-=4;
                        var random = Math.random()*1000;
                        if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                        if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;
                }
            }

            // Check if the tiger is near the bear. If so, then have the bear attack it.
            var closestBear;
            var closest = 100;
            var closestBearFound = false;
            var tigerKnockback;
            var knockbackFrame = 0;
            for (let i = 0; i < enemyList.length; i++) {
                if (!enemyList[i].enemy.src.includes("transform")) {
                    // Look for the closest bear if the bear is in front of the tiger.
                    if ((enemyList[i].enemy_x - hero_x) < closest && (enemyList[i].enemy_x - hero_x) > 0) {
                        closest = enemyList[i].enemy_x - hero_x;
                        closestBearFound = true;
                        closestBear = i;
                    }
                }
            }

            // Knocks back tiger.
            if (closestBearFound && knockbackFrame == 0 && !dying && !pause && hero_y > canvas.height/12 + 440 - 10) {
                var health = document.getElementById("bar");
                tigerKnockback = setInterval(function() {   var imgNum = (knockbackFrame % 3) + 1;
                                                            hero.src = "Tiger Hit/tigerhit" + imgNum.toString() + ".png";
                                                            hero_x -= 1;
                                                            bar_width -= 0.2;
                                                            health.style.width = bar_width.toString()+"px";
                                                            if (hero_x < 0) hero_x = 0; // Keep avatar in bounds
                                                            if (background_x > 0) background_x = -1360; // Scroll background.
                                                            knockbackFrame++; }, 100);
                setTimeout(function(){  clearInterval(tigerKnockback);
                                        hero.src = "Tiger Walking/tiger6.png"; }, 600);
            }

            // Check if the health bar is empty. If so, then run the dying hero animation :,( and end the game.
            if (bar_width <= 0 && !dying && !pause && jumpFrame == 0) {
                var deadFrame = 0;
                dying = true;
                clearInterval(walkingInterval);
                var tigerDead = setInterval(function() {    var imgNum = (deadFrame % 9) + 1                                  
                                                            hero.src = "Tiger Hit/tigerhit" + imgNum.toString() + ".png";
                                                            deadFrame++;
                                                            if (deadFrame == 9) {
                                                                deadFrame = 8;
                                                            }
                                                        }, 200);
                setTimeout(function() { clearInterval(tigerDead);
                                        clearInterval(interval);
                                        clearInterval(clock);
                                        var endGame = document.getElementById("endGameBack");
                                        endGame.style.display = "block";
                                        }, 2300);
            }
            
            if (knockbackFrame > 3) knockbackFrame++;
            if (knockbackFrame > 270) knockbackFrame = 0;

            // Move the tiger up if the jump has started, and down after some time.
            // 0.1*jumpFrame for acceleration.
            if (!dying && !pause) {
                if (jumpFrame > 1 && jumpFrame <= 5) hero_y = hero_y - 6 + 0.1*(jumpFrame + 6);
                if (jumpFrame > 5) {
                    clearInterval(jumpInterval);
                    
                    if (movingLeft || hero.src.includes("TigerJump5") || hero.src.includes("TigerJump6"))
                        hero.src = "Tiger Jump/TigerJump6.png";
                    else
                        hero.src = "Tiger Jump/TigerJump3.png";

                    hero_y = hero_y + 0.1*(jumpFrame-4);
                    if (hero_y >= canvas.height/12 + 440) {
                        jumpFrame = 0;
                        hero_y = canvas.height/12 + 440;
                        if (movingLeft || hero.src.includes("TigerJump6"))
                            hero.src = "Tiger Walking/tiger5.png";
                        else
                            hero.src = "Tiger Walking/tiger6.png";
                    }
                    else jumpFrame++;
                }
            }

            ctx.drawImage(back_background, 0, 0);

            ctx.drawImage(clouds, clouds_x, 0);
            if (!pause) clouds_x -= 0.5;
            if (clouds_x <= -1390) clouds_x = 0; // Scroll clouds.

            ctx.drawImage(background, background_x, background_y);
            ctx.drawImage(hero, hero_x, hero_y, 150, 150);
            for (let i = 0; i < enemyList.length; i++) {
                ctx.drawImage(enemyList[i].enemy, enemyList[i].enemy_x, enemyList[i].enemy_y, 150, 150);
            }
            ctx.drawImage(foreground, background_x, background_y);     
        }

    </script> 

</body>

</html>