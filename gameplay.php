<!DOCTYPE html>
<html>
<?php 
        if (isset($_COOKIE["level"])) {
            echo "<p1 id= 'level'>Level ".$_COOKIE["level"]."</p1>";
        }
        else {
            setcookie("level", "1", 0, "/");
        }
        setcookie("mistakes", "0", 0, "/");
?>


<head>
    <!-- the next three lines try to discourage browser from keeping page in cache -->
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="cache-control" content="no-store">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
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
            <p id= "endGameTxt"><b>The Backwood Bears have defeated
                you this time! But they haven't managed to find your restart 
                code yet! <br> You have another chance! <br> Fight again to keep magic 
                alive in the wood! </b></p>
        </div>
        <button id="restart">Restart?</button>
    </div>
    <i class="fas fa-volume-mute" id="muted"></i>
    <i class="fas fa-volume-up" id="volume-on"></i>



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
        var hero_y = canvas.height/12 + 200;
        var hero = new Image();
        hero.src = "Tiger Walking/tiger5.png";


        var background = new Image();
        background.src = "Background.png";
        var background_x = -700;
        var background_y = 0;
        ctx.drawImage(background, background_x , background_y);


        var soundtrack = document.createElement("AUDIO");
        soundtrack.src = "soundtrack.mp3";
        soundtrack.loop = true;
        soundtrack.volume = 0.5;
        
        // Update the canvas every 10 milliseconds.
        var interval = setInterval(function () {update(); }, 10);

        // Respond to different keyboard presses.
        window.addEventListener('keydown', moveObject, false);
        window.addEventListener('keyup', stopMoveObject, false);
        window.addEventListener('keypress', bearHit, false);

        var muted = document.getElementById("muted");
        var sound = document.getElementById("volume-on");
        var restart = document.getElementById("restart");

        // Turn sound on.
        muted.addEventListener('click', function() {muted.style.display = "none";
                                                    sound.style.display = "block";
                                                    soundtrack.play();});

        // Turn sound off.
        sound.addEventListener('click', function() {muted.style.display = "block";
                                                    sound.style.display = "none";
                                                    soundtrack.pause();});

        // Reload the page in the event that the user loses and wants to restart.
        restart.addEventListener('click', function() {location.reload();});

        // The amount of time that the user has survived.
        var clock = setInterval(function() { var points = document.getElementById("time");
                                             seconds++;
                                             points.innerHTML = "Points:      " + seconds;
                                           }, 1000);

        // Add an enemy every 5 seconds.
        var enemyClock = setInterval(function() {enemyInit(canvas);}, 5000);

        // Switch to the coding HTML page after 10 seconds (will obviously be longer in the actual game).
        // setTimeout(function() {window.location.href = "./codeLevel1.php";}, 10000);
        var level = document.getElementById("level");
        setTimeout(function() { level.style.display = "none";}, 5000);

        // Initialize other variables.
        var enemyList = [];
        let movingLeft = false;
        let movingRight = false;
        let startWalk = false;
        let walkFrame = 0;
        var startAttack = false;
        let attackFrame = 0;
        var firstHit = false;
        var dying = false;

        var walkingInterval;
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
                var enemy_y = canvas.height/12 + 200;
                var enemy_hit = 0;  // How long the enemy has been hit for
                var enemyFrame = 0; // The different frames for the enemy walk
                var hitFrame = 0; // The different frames for when the enemy is hit.
                var hitNum = 0; // The amount of times the enemy has been hit.
                var enemyDown = 0; // The amount of time the enemy has been defeated for.
                var bearInterval; // The interval for all bear animations.
                bearInterval = setInterval(function() { var imgNum = (enemyFrame % 4) + 1;
                                                        enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                        enemyFrame++; 
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
                        enemyList[i].bearInterval = setInterval(function() {var imgNum = (enemyFrame % 4) + 1;
                                                                         enemyList[i].enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                                         enemyFrame++; 
                                                                        }, 200);
                        var random = Math.random()*100;
                        enemyList[i].enemy_x = canvas.width + random;
                        enemyList[i].enemy_y = canvas.height/12 + 200;
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
            if (dying) return;
            const LEFT = 37;
            const RIGHT = 39;
            const UP = 87;
            const SPACEBAR = 32;

            if (event.keyCode == LEFT) {
                movingLeft = true;
                runLeft();
            }
            else if (event.keyCode == RIGHT) {
                movingRight = true;
                runRight();
            }
        }

        function bearHit() {
            if (dying) return;

            const SPACEBAR = 32;
            if (event.keyCode == SPACEBAR) {
               
                if (!startAttack && !dying){
                    clearInterval(walkingInterval);
                    startWalk = false;
                    heroAttack = setInterval(function() {   var imgNum = (attackFrame % 7) + 1;
                                                            if (movingLeft || hero.src.includes("tiger5.png") || hero.src.includes("LTigerAttack")) 
                                                                hero.src = "Tiger Attack/LTigerAttack" + imgNum.toString() +".png";
                                                            else 
                                                                hero.src = "Tiger Attack/RTigerAttack" + imgNum.toString() +".png";
                                                            attackFrame++;
                                                            }, 70);
                    
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
                                            
                                        }, 700);
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
            if (!startWalk && !startAttack && !dying) { 
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
            if (!startWalk && !startAttack && !dying) {
                walkingInterval = setInterval(function(){   var imgNum = (walkFrame % 4) + 7;
                                                            hero.src = "Tiger Walking/tiger" + imgNum.toString() + ".png";
                                                            walkFrame++;
                                                            if (imgNum % 2 == 0) walking.play();
                                                        }, 150);
                startWalk = true;
            } 
        }

        // Stops moving if keyup.
        function stopMoveObject() {
            if (dying) return;

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
            background.src = "Background.png";
            for (let i = 0; i < enemyList.length; i++) {
                // Spell 1 animation.
                if (enemyList[i].hitNum >= 3 && enemyList[i].enemyDown == 0)  {
                    clearInterval(enemyList[i].bearInterval);
                    enemyList[i].hitNum = 0;
                    var enemyFrame = 0;
                    enemyList[i].bearInterval = setInterval(function(){ var imgNum = (enemyFrame % 18) + 1;
                                                                     enemyList[i].enemy.src = "Spell 1/transform" + imgNum.toString() + ".png";
                                                                     enemyFrame++;
                                                                     if (enemyFrame == 18) {
                                                                         enemyFrame = 15; // Loop the flapping animation.
                                                                     }
                                                                     enemyList[i].enemyDown++;
                                                                     if (enemyFrame >= 15)
                                                                     enemyList[i].enemy_y-=100; // Start going up!
                                                                   }, 200);
                }
                if (!enemyList[i].enemy.src.includes("transform")) {
                    if (enemyList[i].enemy_hit == 0) 
                        enemyList[i].enemy_x -=7;
                        // Stop enemy from moving after hit for two seconds.
                    else if (enemyList[i].enemy_hit >= 10) {
                        enemyList[i].enemy_hit = 0;
                        clearInterval(enemyList[i].bearInterval);
                        var enemyFrame = 0;
                        enemyList[i].hitFrame = 0;
                        enemyList[i].bearInterval = setInterval(function(){    var imgNum = (enemyFrame % 4) + 1;
                                                                            enemyList[i].enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                                            enemyFrame++; 
                                                                        }, 200);
                    }
                    var random = Math.random()*1000;
                    if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                    if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;        
                }
            }

            if (movingLeft && !dying) {
                hero_x-=6;
                background_x+=6;
                if (hero_x < 0) hero_x = 0; // Keep avatar in bounds
                if (background_x > 0) background_x = -1290; // Scroll background.
                for (let i = 0; i < enemyList.length; i++) {
                        enemyList[i].enemy_x+=6;
                        var random = Math.random()*1000;
                        if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                        if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;
                    
                }
            }
            if (movingRight && !dying) {
                hero_x+=6;
                background_x-=6;
                if (hero_x > canvas.width - 400) hero_x = canvas.width - 400;
                if (background_x < -1290) background_x = 0; // Scroll background.
                for (let i = 0; i < enemyList.length; i++) {
                        enemyList[i].enemy_x-=6;
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
            if (closestBearFound && knockbackFrame == 0 && !dying) {
                var health = document.getElementById("bar");
                tigerKnockback = setInterval(function() {   var imgNum = (knockbackFrame % 3) + 1;
                                                            hero.src = "Tiger Hit/tigerhit" + imgNum.toString() + ".png";
                                                            hero_x -= 2;
                                                            bar_width -= 0.2;
                                                            health.style.width = bar_width.toString()+"px";
                                                            if (hero_x < 0) hero_x = 0; // Keep avatar in bounds
                                                            if (background_x > 0) background_x = -1290; // Scroll background.
                                                            knockbackFrame++; }, 100);
                setTimeout(function(){  clearInterval(tigerKnockback);
                                        hero.src = "Tiger Walking/tiger6.png"; }, 600);
            }

            // Check if the health bar is empty. If so, then run the dying hero animation :,( and end the game.
            if (bar_width <= 0 && !dying) {
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
            

            ctx.drawImage(background, background_x, background_y);
            ctx.drawImage(hero, hero_x, hero_y);
            for (let i = 0; i < enemyList.length; i++) {
                ctx.drawImage(enemyList[i].enemy, enemyList[i].enemy_x, enemyList[i].enemy_y);
            } 
        }

    </script> 

</body>

</html>