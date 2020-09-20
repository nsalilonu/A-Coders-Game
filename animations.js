// Initialize the hero.
var hero_x;
var hero_y;
var hero;

function initializeHero(canvas) {
hero_x = 10;
hero_y = canvas.height/12 + 200;
hero = new Image();
hero.src = "Tiger Walking/tiger5.png";
console.log("Hero source: %s", hero.src)
}

// Initialize the background:
var background = new Image();
background.src = "titlePage.png";
console.log("Background source: %s", background.src);
var background_x = 0;
var background_y = 0;

// Initialize other variables.
var enemyList = [];
let movingLeft = false;
let movingRight = false;
let startWalk = false;
let walkFrame = 0;
var startAttack = false;
let attackFrame = 0;
var firstHit = false;

var walkingInterval;
var heroAttack;
var walking = document.createElement("AUDIO");
walking.src = "footstep.mp3";
walking.volume = 0.2;
walking.playbackRate = 1.9;

function enemyInit(canvas) {
    console.log("Calling enemyInit!");
    // Only have 20 images in the array at a time.
    if (enemyList.length < 10) {
        var enemy = new Image();
        enemy.src = "Enemy Walking/enemy5.png";
        

        // Put the enemy in a random place off the canvas.
        var random = Math.random()*100;
        var enemy_x = canvas.width + random; 
        var enemy_hit = 0;  
        var enemyFrame = 1;
        var bearHit;
        var hitFrame = 0;
        var hitNum = 0;
        var enemyWalk = setInterval(function() { var imgNum = (enemyFrame % 4) + 1;
                                                enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                enemyFrame++; 
                                            }, 200);
        enemyList.push({enemy: enemy, enemy_x: enemy_x, enemy_hit: enemy_hit, hitFrame: hitFrame, bearHit: bearHit, enemyWalk: enemyWalk, hitNum: hitNum});
    }

    // If we have 20 images in the array, make visible a defeated enemy.
    else {
        for (let i = 0; i < enemyList.length; i++) {
            if (enemyList[i].enemy.hidden) {
                enemyList[i].enemy.hidden = false;
                var random = Math.random()*100;
                enemyList[i].enemy_x = canvas.width + random;
                break;
            }
        }
    }
}

function moveObject() {
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
    const SPACEBAR = 32;
    if (event.keyCode == SPACEBAR) {
        if (heroAttack != undefined)
            clearInterval(heroAttack);
        if (!startAttack){
            heroAttack = setInterval(function() {   var imgNum = (attackFrame % 7) + 1;
                                                    if (movingLeft || hero.src.includes("tiger5.png") || hero.src.includes("LTigerAttack"))
                                                        hero.src = "Tiger Attack/LTigerAttack" + imgNum.toString() +".png";
                                                    else if (movingRight || hero.src.includes("tiger6.png") || hero.src.includes("RTigerAttack")) 
                                                        hero.src = "Tiger Attack/RTigerAttack" + imgNum.toString() +".png";
                                                    attackFrame++;
                                                    }, 70);
            
            setTimeout(function() { if (hero.src.includes("RTigerAttack") && (!movingLeft && !movingRight))
                                        hero.src = "Tiger Walking/tiger6.png";  
                                    else if (hero.src.includes("LTigerAttack") && (!movingLeft && !movingRight))
                                        hero.src = "Tiger Walking/tiger5.png"; 
                                    else if (movingRight) {
                                        hero.src = "Tiger Walking/tiger10.png"; 
                                    }
                                    else if (movingLeft) {
                                        hero.src = "Tiger Walking/tiger4.png";
                                    } 
                                    clearInterval(heroAttack);
                                    attackFrame = 0;
                                    walkFrame = 0;
                                    startAttack = false;
                                }, 700);
            startAttack = true;
        }

        // Make bear fall back if hero hits it.
        var closestBear;
        var closest = 200;
        var closestBearFound = false;
        for (let i = 0; i < enemyList.length; i++) {
            if (!enemyList[i].enemy.hidden) {
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
        
        if (closestBearFound && !firstHit) {
        enemyList[closestBear].enemy_hit = 0;
        enemyList[closestBear].hitFrame = 0;
        clearInterval(enemyList[closestBear].enemyWalk); // Stops walking
        clearInterval(enemyList[closestBear].bearHit);
        enemyList[closestBear].bearHit = setInterval(function (){   if (enemyList[closestBear].hitFrame < 3) {
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
    if (!startWalk && !startAttack) { 
        walkingInterval = setInterval(function(){   var imgNum = (walkFrame % 4) + 1;
                                                    hero.src = "Tiger Walking/tiger" + imgNum.toString() + ".png";
                                                    walkFrame++;
                                                    if (imgNum % 2 == 0)
                                                    walking.play();
                                                }, 150);
        startWalk = true;
        
    }
}

function runRight() {
    // Change image every 0.5 second when button is first pressed down.
    if (!startWalk && !startAttack) { 
        walkingInterval = setInterval(function(){   var imgNum = (walkFrame % 4) + 7;
                                                    hero.src = "Tiger Walking/tiger" + imgNum.toString() + ".png";
                                                    walkFrame++;
                                                    if (imgNum % 2 == 0)
                                                    walking.play();
                                                }, 150);
        startWalk = true;
    } 
}

// Stops moving if keyup.
function stopMoveObject() {
    const LEFT = 37;
    const RIGHT = 39;
    const SPACEBAR = 32;

    if (event.keyCode == LEFT) {
        movingLeft = false;
        startWalk = false;
        clearInterval(walkingInterval); // Stop walking animation
        walkFrame = 0;
        hero.src = "Tiger Walking/tiger5.png"; // Stationary avatar looking left
    }
    else if (event.keyCode == RIGHT) {
        movingRight = false;
        startWalk = false;
        clearInterval(walkingInterval); // Stop walking animation
        walkFrame = 0;
        hero.src = "Tiger Walking/tiger6.png"; // Stationary avatar looking right
    }

     if (event.keyCode == SPACEBAR) {
        firstHit = false;
        startAttack = false;
     }
}

function update(gameStart, canvas, ctx) {
    // Clear the canvas.
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Move the enemy, change the background.
    if (gameStart) {
        background.src = "Background.png";
        for (let i = 0; i < enemyList.length; i++) {
            // if (enemyList[i].hitNum >= 3) // Insert spell 1 animation here.
            if (!enemyList[i].enemy.hidden) {
                if (enemyList[i].enemy_hit == 0)
                    enemyList[i].enemy_x -=7;
                    // Stop enemy from moving after hit for two seconds.
                else if (enemyList[i].enemy_hit >= 10) {
                    enemyList[i].enemy_hit = 0;
                    clearInterval(enemyList[i].bearHit);
                    var enemyFrame = 0;
                    enemyList[i].hitFrame = 0;
                    enemyList[i].enemyWalk = setInterval(function(){    var imgNum = (enemyFrame % 4) + 1;
                                                                        enemyList[i].enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                                        enemyFrame++; 
                                                                    }, 200);
                }
                var random = Math.random()*1000;
                if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;        
            }
        }
    }

    if (movingLeft) {
        hero_x-=6;
        background_x+=6;
        if (hero_x < 0) hero_x = 0; // Keep avatar in bounds
        if (background_x > 0) background_x = -1290; // Scroll background.
        for (let i = 0; i < enemyList.length; i++) {
            if (!enemyList[i].enemy.hidden) {
                enemyList[i].enemy_x+=6;
                var random = Math.random()*1000;
                if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;
            }
        }
    }
    if (movingRight) {
        hero_x+=6;
        background_x-=6;
        if (hero_x > canvas.width - 400) hero_x = canvas.width - 400;
        if (background_x < -1290) background_x = 0; // Scroll background.
        for (let i = 0; i < enemyList.length; i++) {
            if (!enemyList[i].enemy.hidden) {
                enemyList[i].enemy_x-=6;
                var random = Math.random()*1000;
                if (enemyList[i].enemy_x < -600) enemyList[i].enemy_x = canvas.width + random;
                if (enemyList[i].enemy_x > 2500) enemyList[i].enemy_x = canvas.width + random;
            }
        }
    }

    // Check if the tiger is near the bear. If so, then have the bear attack it.
    var closestBear;
    var closest = 100;
    var closestBearFound = false;
    var tigerKnockback;
    var knockbackFrame = 0;
    for (let i = 0; i < enemyList.length; i++) {
        if (!enemyList[i].enemy.hidden) {
            // Look for the closest bear if the bear is in front of the tiger.
            if ((enemyList[i].enemy_x - hero_x) < closest && (enemyList[i].enemy_x - hero_x) > 0) {
                closest = enemyList[i].enemy_x - hero_x;
                closestBearFound = true;
                closestBear = i;
            }
        }
    }

    // Knocks back tiger.
    if (closestBearFound && knockbackFrame == 0) {
        tigerKnockback = setInterval(function() {   var imgNum = (knockbackFrame % 3) + 1;
                                                    hero.src = "Tiger Hit/tigerhit" + imgNum.toString() + ".png";
                                                    hero_x -= 2;
                                                    if (hero_x < 0) hero_x = 0; // Keep avatar in bounds
                                                    if (background_x > 0) background_x = -1290; // Scroll background.
                                                    knockbackFrame++; }, 100);
        setTimeout(function(){  clearInterval (tigerKnockback)
                                hero.src = "Tiger Walking/tiger5.png"; }, 600);
    }
    
    if (knockbackFrame > 3) knockbackFrame++;
       
    if (knockbackFrame > 270) knockbackFrame = 0;
    

    background.onload = function(){ctx.drawImage(background, background_x, background_y);};
    console.log(background.src);
    
    if (gameStart) {
        ctx.drawImage(hero, hero_x, hero_y);
        for (let i = 0; i < enemyList.length; i++) {
            ctx.drawImage(enemyList[i].enemy, enemyList[i].enemy_x, hero_y);
        }
    }      
}

export {update, enemyInit, moveObject, stopMoveObject, initializeHero, bearHit};