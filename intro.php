<!DOCTYPE html>
<html>
    <?php
    setcookie("intro", "1", 0, "/"); // The intro will run if the user hasn't visited this page. Otherwise, they will see quick instructions.
    ?>
    <head>
        <!-- the next three lines try to discourage browser from keeping page in cache -->
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta http-equiv="cache-control" content="no-store">
        <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/3f70d76f1c.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="./favicon.ico" />
        <title id="title">  A Coder's Game </title>
    </head>

    <link href="style.css" type="text/css" rel="stylesheet" />


    <body style="background-color: rgb(226, 113, 147);">

    <p1 id= "time">Points: 0</p1>
    <p1 id= "health">Health:</p1>
    <div id= "progress"></div>
    <div id= "bar"></div>


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

    <div id="monologue">
        <p1 id="monologueText">Ok, this is the last time I do this. Then I'm giving up!</p1>
        <i class="fas fa-forward" id="next"></i>
        <button id="startGame"><b>To the Wood!</b></button>
    </div>

        <canvas id="canvas"></canvas>

        <script type="module">
        var bar_width = 330;

        var canvas = document.getElementById("canvas");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        var ctx = canvas.getContext("2d");
        var background = new Image();
        background.src = "introBackground.png";
        var background_x = -15;
        var background_y = 0;
        background.onload = function(){ctx.drawImage(background, background_x, background_y, window.innerWidth, window.innerHeight);};

        // Initialize the hero.
        var hero_x = 700;
        var hero_y = canvas.height/12 + 310;
        var hero = new Image();
        hero.src = "Tiger Hit/tigerhit9.png";

        var soundtrack = document.createElement("AUDIO");
        soundtrack.src = "Intro__A_Coder's_Game.mp3";
        soundtrack.loop = true;
        soundtrack.volume = 0.25;

        window.addEventListener("mouseover", function() {soundtrack.play();});

        // Update the canvas every 10 milliseconds.
        var interval = setInterval(function () {update(); }, 10);

        // Intro bit:
        var next = document.getElementById("next");
        var monologueText = document.getElementById("monologueText");
        var introNum = 0;
        next.addEventListener('click', function() { introNum++; });                                     

        // Respond to different keyboard presses.
        window.addEventListener('keydown', moveObject, false);
        window.addEventListener('keyup', stopMoveObject, false);
        window.addEventListener('keypress', bearHit, false);

        var spell1 = document.getElementById("spell1");
        var spell1Select = document.getElementById("spell1Select");
        var spell2 = document.getElementById("spell2");
        var spell2Select = document.getElementById("spell2Select");
        var spellBox = document.getElementById("spells");

        // Handle the spells.
        spell1.addEventListener('click', function() {   spell1Select.style.display = "block";
                                                        spell1.style.display = "none";
                                                        spell2Select.style.display = "none";
                                                        spell2.style.display = "block";
                                                    });
        spell2.addEventListener('click', function() {   spell2Select.style.display = "block";
                                                        spell2.style.display = "none";
                                                        spell1Select.style.display = "none";
                                                        spell1.style.display = "block";
                                                    });

        // Initialize other variables.
        let movingLeft = false;
        let movingRight = false;
        let startWalk = false;
        let startJump = false;
        var jumpFrame = 0;
        let walkFrame = 0;
        var startAttack = false;
        let attackFrame = 0;
        var firstHit = false;
        var pause = false;
        var eatFrame = 0;


        var walkingInterval;        
        var jumpInterval; 
        var heroAttack;
        var walking = document.createElement("AUDIO");
        walking.src = "footstep.mp3";
        walking.volume = 0.2;
        walking.playbackRate = 1.9;

        function moveObject() {
            const LEFT = 37;
            const RIGHT = 39;
            const UP = 38;
            const SHIFT = 16;

            if (event.keyCode == LEFT && !pause && introNum >= 1) {
                movingLeft = true;
                runLeft();
            } 
            else if (event.keyCode == RIGHT && !pause && introNum >= 2) {
                movingRight = true;
                runRight();
            }
            else if (event.keyCode == UP && !pause && introNum >= 3) {
                jumpUp();
            }
            if (event.keyCode == SHIFT && !pause && introNum >= 23) {
                spellBox.style.display = "block";
                pause = true;
            }
            else if (event.keyCode == SHIFT && pause && introNum >= 24) {
                spellBox.style.display = "none";
                pause = false;
            }
        }

        function bearHit() {
            if (pause) return;

            const SPACEBAR = 32;
            if (event.keyCode == SPACEBAR && introNum >= 21) {
               
                if (!startAttack){
                    clearInterval(walkingInterval);
                    startWalk = false;
                    heroAttack = setInterval(function() {   var imgNum = 7;
                                                            if (movingLeft || hero.src.includes("tiger5.png") || hero.src.includes("LTigerAttack")) 
                                                                hero.src = "Tiger Attack/LTigerAttack" + imgNum.toString() +".png";
                                                            else 
                                                                hero.src = "Tiger Attack/RTigerAttack" + imgNum.toString() +".png";
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
            }
        }

        function runLeft() {
            // Change image every 0.5 second when button is first pressed down.
            if (!startWalk && !startAttack && !pause && jumpFrame == 0) { 
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
            if (!startWalk && !startAttack && !startJump && !pause && jumpFrame == 0) {
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
            if (!pause && jumpFrame == 0) {
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
            if (pause) return;

            const LEFT = 37;
            const RIGHT = 39;
            const SPACEBAR = 32;

            if (event.keyCode == LEFT && introNum >= 1) {
                movingLeft = false;
                startWalk = false;
                clearInterval(walkingInterval); // Stop walking animation
                walkFrame = 0;
                if (!startAttack) hero.src = "Tiger Walking/tiger5.png"; // Stationary avatar looking left 
            }
            else if (event.keyCode == RIGHT && introNum >= 2) {
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
            

            if (movingLeft && !pause) {
                hero_x-=4;
                if (hero_x < 300) hero_x = 300; // Keep avatar in bounds
            }
            if (movingRight && !pause) {
                hero_x+=4;
                if (hero_x > canvas.width - 470) hero_x = canvas.width - 470; 
            }

            

            // Move the tiger up if the jump has started, and down after some time.
            // 0.1*jumpFrame for acceleration.
            if (!pause) {
                if (jumpFrame > 1 && jumpFrame <= 5) hero_y = hero_y - 6 + 0.1*(jumpFrame + 6);
                if (jumpFrame > 5) {
                    clearInterval(jumpInterval);
                    
                    if (movingLeft || hero.src.includes("TigerJump5") || hero.src.includes("TigerJump6"))
                        hero.src = "Tiger Jump/TigerJump6.png";
                    else
                        hero.src = "Tiger Jump/TigerJump3.png";

                    hero_y = hero_y + 0.1*(jumpFrame-4);
                    if (hero_y >= canvas.height/12 + 310) {
                        jumpFrame = 0;
                        hero_y = canvas.height/12 + 310;
                        if (movingLeft || hero.src.includes("TigerJump6"))
                            hero.src = "Tiger Walking/tiger5.png";
                        else
                            hero.src = "Tiger Walking/tiger6.png";
                    }
                    else jumpFrame++;
                }
            }

            switch(introNum) {
                case 1:
                    next.style.display = "none";
                    monologueText.innerHTML = "If you can hear me, try moving left with the left arrow key.";
                    if (movingLeft) {
                    monologueText.innerHTML = `So THAT time it worked?! Of course NOW it works! So many days of work...could this
                                            be it? Ok, let's not get ahead of ourselves...try moving right with the right arrow key...?`;
                    introNum++;
                    }
                    break;
             

                case 2: 
                    if (movingRight) {
                    monologueText.innerHTML = `Marvelous! This is extrodinary! I did it! I did it! Ok...ok...wait...we're not 
                                                out of the woods yet. Can you jump with the up arrow key?`;
                    introNum++;
                    }
                    break;
             

                case 3:
                    if (jumpFrame > 0) {
                    monologueText.innerHTML = `HaHA! YES!!! YES!!! I've still got it!!! I...ahh..ahem...cough...forgive me, I got a bit overexcited
                                                there. Now that you are alive and have consciousness, I suppose you have a couple of questions regarding the 
                                                purpose of your existence.`;
                    next.style.display = "block";
                    }
                    break; 

                case 4:
                    monologueText.innerHTML = `First off, let me introduce myself. I am your creator. No need for the burning of children to mollify my
                                           unpredictable rage or any of that...though a good grovel or two would be accepted quite warmly.`;
                    break;
            
                case 5:
                    monologueText.innerHTML = `Your purpose, well, this part is quite embarrassing, but I suppose you have a right to know. I've tried 
                                            this before, the whole "forming intelligent life" thing, and it sort of got out of hand...`;
                    break;

                case 6:
                    monologueText.innerHTML = `His name was Martin. Lovely chap. A little bear in neat blue overalls. Marvelously clever, too. I cared
                                            for him dearly, and would make him all sorts of things to play with in this splendid world.`;
                    break;

                case 7:
                    monologueText.innerHTML =   `One day, he asked me how I made these things. I decided to teach him a bit of code...ahhh...I suppose that 
                                            doesn't mean anything to you. What's a word vague enough to mean everything and therefore nothing at all? Semiformal?
                                            No, that won't do. Let's call it magic.`;
                    break;

                case 8:
                    monologueText.innerHTML = `I decided to teach Martin a bit of magic. It was nice having someone to
                                           talk to about this sort of thing. It can get rather lonely sometimes, and he was a fast learner.`;
                    break;

                case 9:
                    monologueText.innerHTML = `As our lessons became more advanced, Martin would start to do some magic 
                                           without me. At some point I briefly left to get some water and came back to 
                                           find him in a trench coat and fedora.`;
                    break;
            
                case 10:
                    monologueText.innerHTML = `"More his style" he said. I was taken a little aback but didn't think too much of it. You musn't think
                                            too harshly of me...the entire purpose of creating "intelligent" life is to give it freedom to be
                                            whatever it wants to be.`;
                    break;
            
                case 11:
                    monologueText.innerHTML = `However, his changes became more worrisome. He started making copies of himself. He told me he wanted
                                           to have friends just like him that did everything he wanted.`;
                    break;
            
                case 12:
                    monologueText.innerHTML = `"But that isn't what a friend is! That's a minion, a mindless cog in a machine, a gang!" 
                                                I blurted out in disbelief.`;
                    break;
            
                case 13:
                    monologueText.innerHTML = `"A gang...I like that." Martin replied.`; 
                    break;
            
                case 14:
                    monologueText.innerHTML = `As Martin's gang became more numerous and, for lack of a better word, disturbing, I decided that
                                           was it. I said to him, "Martin, I request that you stop this immediately. I cannot teach you anymore if you 
                                           use your newfound knowledge in this way."`; 
                    break;
            
                case 15: 
                    monologueText.innerHTML = `Then he smiled at me, a smile that sent a chill to my bones.`;
                    break; 
            
                case 16:
                    monologueText.innerHTML = `"You think I need you?"`; 
                    break;
    
                case 17:
                    monologueText.innerHTML = `He distorted this world, a backwood, making it into an eternal night. He took his minions with him. 
                                               And I can't stop him because the one rule by which I'm bound is that I cannot interfere directly in the 
                                               affairs of what I create.`; 
                    break;

                case 18:
                    monologueText.innerHTML = `He and his "Backwood Bear Gang" are threatening the peace of this universe that I have created, and I 
                                               need you to restore it.`;
                    break;
                
                case 19:
                    monologueText.innerHTML = `You and Martin are different. I made you taking special care to make sure you had a high capacity
                                               to understand the concepts of kindness, bravery, and compassion. But like Martin, what you do is 
                                               completely your choice.`;
                    break;
                
                case 20:
                    next.style.display = "none";
                    monologueText.innerHTML = `Should you choose to go on to help me, I gave you a little wand to protect you! Try
                                               waving it with SPACEBAR.`;
                    introNum++;
                    break;

                case 21:
                    if (startAttack) {
                    monologueText.innerHTML = `Excellent job! When you wave the wand enough times at Martin's gang, they will be transformed in such
                                               a way that they're harmless. <br>You want a sword?! <b>NO!</b> You could kill someone with that! We're not killing
                                               anybody! All life is precious!`;
                    next.style.display = "block";
                    }
                    break;

                case 22:
                    next.style.display = "none";
                    monologueText.innerHTML = `Can you smack them with the wand? Of course not! His gang isn't some naughty puppy that wet the
                                               carpet! Now, you can select different spells by pressing the SHIFT key. Try that!`;
                    introNum++;
                    break;
                
                case 23: 
                    if (pause) {
                        monologueText.innerHTML = `Fantastic! As you can see, nothing can move when you are selecting spells. It's the 
                                                   most safety I can offer you. Now press SHIFT again.`;
                        introNum++;
                    }
                    break;
                
                case 24: 
                    if (!pause) {
                        monologueText.innerHTML = `And you can move once more! Not too much trouble, is it? To motivate you, I'm giving 
                                                   you little points in the corner that will increase as you go along and defeat more 
                                                   of Martin's gang!`;
                        next.style.display = "block";
                    }
                    break;
                
                case 25: 
                    monologueText.innerHTML = `What? You'd rather have a spell that provides you with an unlimited supply of warm
                                                chocolate chip cookies? Wow, you ARE different from Martin. Very well,
                                                you get ONE cookie, and we'll see about some more later, OK?`;
                    break;
                
                case 26:                     
                    var eat = setInterval(function()  { var imgNum = (eatFrame % 10) + 1;
                                                        hero.src = "Cookie/eat" + imgNum.toString() + ".png";
                                                        eatFrame++;
                                                      }, 200)
                    setTimeout(function() { clearInterval(eat);
                                            hero.src = "Tiger Walking/tiger5.png";
                                          }, 2300);
                    introNum++;
                    break;

                case 27: 
 
                    monologueText.innerHTML = `Lastly, keep an eye on your health! Martin's gang is not quite so opposed to violence
                                              as we are. Well, as I am. We'll work on your more "brute justice" tendencies.`;
                    break;
                
                case 28: 
                    monologueText.innerHTML = `Now, to the wood! Oh, you thought this was it? No, this is a rather pleasant clearing to
                                              ease your transition. You'll see where you'll be in a moment, if you choose to come.`;
                    var startGame = document.getElementById("startGame");
                    startGame.style.display = "block";
                    next.style.display = "none";
                    startGame.addEventListener("click", function() {window.location.href = "./gameplay.php";});
                    break;
            }

            ctx.drawImage(background, background_x, background_y);
            ctx.drawImage(hero, hero_x, hero_y, 150, 150);

            
        }

        </script>
    </body>
</html>