<?php
include 'head.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Snake</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png">
</head>

<body>
<h1>
    <a href="index.php"><img id="logo" src="images\pineapple.png" alt="logo" style="filter:<?php echo $image_colour; ?>;"></a>
    Snake
</h1>

<canvas id="snakeCanvas" width="400" height="400" style="border: solid <?php echo $secondary_colour; ?>; display: block; margin:auto;"></canvas>

<p id="snakeMessage">Points: 0</p>

<img id="pineappleImage" src="images/pineapple.png" alt="pineapple" style="display: none;">

<script>
    const c = document.getElementById("snakeCanvas");
    const ctx = c.getContext("2d");
    ctx.strokeStyle = "<?php echo $text_colour; ?>";
    ctx.fillStyle = "<?php echo $secondary_colour; ?>";
    ctx.font = "30px Arial";
    ctx.textAlign = "center";

    const canvasSize = 400;
    const cellSize = 20;
    const gameSpeed = 200;

    let points = 0;
    let turned = false;

    class Coord {
        constructor(x, y) {
            this.x = x;
            this.y = y;
        }
    }

    snake = {
        position: new Coord(cellSize, cellSize),
        body: [],
        direction: "e",
        alive: true
    }

    food = {
        position: new Coord(Math.floor(Math.random() * ((canvasSize/cellSize) - 1) + 1) * cellSize -cellSize/2,
            Math.floor(Math.random() * ((canvasSize/cellSize) - 1) + 1) * cellSize -cellSize/2)
    }

    function drawCanvas() {
        ctx.clearRect(0, 0, canvasSize, canvasSize);
        //Draw food
        ctx.beginPath();
        //ctx.rect(food.position.x+3, food.position.y+3, cellSize-6, cellSize-6);
        ctx.filter = "<?php echo $image_colour; ?>;";
        let img = document.getElementById("pineappleImage");
        ctx.drawImage(img, food.position.x, food.position.y, cellSize, cellSize)
        ctx.stroke();

        //Draw snake head
        ctx.beginPath();
        if ((snake.position.x === food.position.x+0.5*cellSize || snake.position.x === food.position.x-0.5*cellSize) && snake.position.y === food.position.y+0.5*cellSize && snake.direction === "e") {
            ctx.arc(snake.position.x, snake.position.y, cellSize - cellSize / 2 + 2, Math.PI * 0.25, 1.75 * Math.PI);
        } else if ((snake.position.x === food.position.x+1.5*cellSize || snake.position.x === food.position.x+0.5*cellSize) && snake.position.y === food.position.y+0.5*cellSize && snake.direction === "w") {
            ctx.arc(snake.position.x, snake.position.y, cellSize - cellSize / 2 + 2, Math.PI * 1.25, 0.75 * Math.PI);
        } else if ((snake.position.y === food.position.y+0.5*cellSize || snake.position.y === food.position.y+1.5*cellSize) && snake.position.x === food.position.x+0.5*cellSize && snake.direction === "n") {
            ctx.arc(snake.position.x, snake.position.y, cellSize - cellSize / 2 + 2, Math.PI * 1.75, 1.25 * Math.PI);
        } else if ((snake.position.y === food.position.y+0.5*cellSize || snake.position.y === food.position.y-0.5*cellSize) && snake.position.x === food.position.x+0.5*cellSize && snake.direction === "s") {
            ctx.arc(snake.position.x, snake.position.y, cellSize - cellSize / 2 + 2, Math.PI * 0.75, 0.25 * Math.PI);
        } else {
            ctx.arc(snake.position.x, snake.position.y, cellSize - cellSize / 2 + 2, 0, 2 * Math.PI);
        }
        ctx.stroke();

        //Draw snake body
        let pre = structuredClone(snake.position);
        for (let i=0; i<snake.body.length; i++) {
            let temp = structuredClone(snake.body[i]);
            ctx.beginPath();
            ctx.arc(snake.body[i].x, snake.body[i].y, cellSize-cellSize/2, 0, 2 * Math.PI);
            ctx.stroke();
            snake.body[i] = pre;
            pre = temp;
        }
    }

    document.addEventListener("keydown", function(e){
        if (turned === false) {
            switch (e.key) {
                case "w":
                    if (snake.direction !== "s") {
                        snake.direction = "n";
                        turned = true;
                    }
                    break;
                case "s":
                    if (snake.direction !== "n") {
                        snake.direction = "s";
                        turned = true;
                    }
                    break;
                case "a":
                    if (snake.direction !== "e") {
                        snake.direction = "w";
                        turned = true;
                    }
                    break;
                case "d":
                    if (snake.direction !== "w") {
                        snake.direction = "e";
                        turned = true;
                    }
                    break;
            }
        }
    })

    function loop() {
        turned = false;
        if (snake.position.y < cellSize || snake.position.y > canvasSize-cellSize || snake.position.x < cellSize || snake.position.x > canvasSize-cellSize) {
            snake.alive = false;
        } else if (containsObject(snake.position, snake.body.slice(1, snake.body.length-1))){
            snake.alive = false;
        } else {
            switch (snake.direction) {
                case "n":
                    snake.position.y -= cellSize;
                    break;
                case "s":
                    snake.position.y += cellSize;
                    break;
                case "w":
                    snake.position.x -= cellSize;
                    break;
                case "e":
                    snake.position.x += cellSize;
                    break;
            }
            drawCanvas();
        }

        if (snake.position.x === food.position.x+cellSize/2 && snake.position.y === food.position.y+cellSize/2) {
            gotPoint();
        }

        if (snake.alive === true) {
            setTimeout(loop, gameSpeed);
        } else {
            gameEnd()
        }
    }

    function containsObject(obj, list) {
        for (let i = 0; i < list.length; i++) {
            if (list[i].x === obj.x && list[i].y === obj.y) {
                return true;
            }
        }

        return false;
    }

    function gotPoint() {
        points = points + 1;
        snake.body.push(structuredClone(snake.position))
        document.getElementById("snakeMessage").innerText = "Points: " + points;
        do {
            food.position.x = Math.floor(Math.random() * ((canvasSize / cellSize) - 1) + 1) * cellSize - cellSize / 2;
            food.position.y = Math.floor(Math.random() * ((canvasSize / cellSize) - 1) + 1) * cellSize - cellSize / 2;
        } while (containsObject(food.position, snake.body))
    }

    function gameEnd() {
        ctx.fillText("You died", canvasSize/2, canvasSize/2);
    }

    setTimeout(loop, gameSpeed);
</script>
</body>
</html>