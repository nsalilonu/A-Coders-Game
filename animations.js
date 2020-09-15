// Initialize the canvas.
var canvas = document.getElementById("canvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
var ctx = canvas.getContext("2d");

// Initialize the hero.
var hero_x = 10;
var hero_y = canvas.height/12 + 200;
var hero = new Image();
hero.src = "Tiger Walking/tiger5.png";

// Initialize the background:
var background = new Image();
background.src = "Background.png";
var background_x = -700;
var background_y = 0;

// Initialize other variables.
var enemyList = [];

let movingLeft = false;
let movingRight = false;
let startWalk = false;
let walkFrame = 1;
var startAttack = false;
let attackFrame = 0;

var walkingInterval;
var heroAttack;
var walking = document.createElement("AUDIO");
walking.src = "footstep.mp3";
walking.volume = 0.2;
walking.playbackRate = 1.9;

function enemyInit() {
    // Only have 20 images in the array at a time.
    if (enemyList.length < 20) {
        var enemy = new Image();
        enemy.src = "Enemy Walking/enemy5.png";
        

        // Put the enemy in a random place off the canvas.
        var random = Math.random()*100;
        var enemy_x = canvas.width + random; 
        var enemy_y = hero_y;  
        var enemyFrame = 1;
        var enemyWalk = setInterval(function() { var imgNum = (enemyFrame % 4) + 1;
                                                enemy.src = "Enemy Walking/enemy" + imgNum.toString() + ".png";
                                                enemyFrame++; 
                                            }, 200);
        enemyList.push({enemy: enemy, enemy_x: enemy_x});
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
    if (event.keyCode == SPACEBAR) {
        if (!startAttack) {
        heroAttack = setInterval(function() {   var imgNum = (attackFrame % 7) + 1;
                                                if (movingLeft || hero.src.includes("tiger5.png") || hero.src.includes("LTigerAttack"))
                                                    hero.src = "Tiger Attack/LTigerAttack" + imgNum.toString() +".png";
                                                else if (movingRight || hero.src.includes("tiger6.png") || hero.src.includes("RTigerAttack")) 
                                                    hero.src = "Tiger Attack/RTigerAttack" + imgNum.toString() +".png";
                                                attackFrame++;
                                                }, 70);
        startAttack = true;
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
        startAttack = false;
        clearInterval(heroAttack);
        attackFrame = 0;
        if (hero.src.includes("RTigerAttack"))
            hero.src = "Tiger Walking/tiger6.png";  
        else if (hero.src.includes("LTigerAttack"))
            hero.src = "Tiger Walking/tiger5.png";
    }
}

function update(gameStart) {
    // Clear the canvas.
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Move the enemy.
    if (gameStart) {
        for (let i = 0; i < enemyList.length; i++) {
            if (!enemyList[i].enemy.hidden) {
                enemyList[i].enemy_x-=7;
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

    ctx.drawImage(background, background_x, background_y); 
    ctx.drawImage(hero, hero_x, hero_y);
    for (let i = 0; i < enemyList.length; i++) {
        ctx.drawImage(enemyList[i].enemy, enemyList[i].enemy_x, hero_y);
    }      
}

export {update, enemyInit, moveObject, stopMoveObject};