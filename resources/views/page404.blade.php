<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* General Styles */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #6a11cb, #ff6f61);
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
}

.container {
    text-align: center;
}

h1 {
    font-size: 2.5rem;
    margin-top: 20px;
}

p {
    font-size: 1.2rem;
    margin: 10px 0 20px;
}

.home-button {
    display: inline-block;
    padding: 10px 20px;
    background: #ff6f61;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    transition: background 0.3s ease;
}

.home-button:hover {
    background: #ff3b2f;
}

/* 3D Cube Animation */
.cube {
    width: 100px;
    height: 100px;
    position: relative;
    transform-style: preserve-3d;
    animation: rotate 8s infinite linear;
}

.face {
    position: absolute;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
}

.front {
    transform: translateZ(50px);
}

.back {
    transform: rotateY(180deg) translateZ(50px);
}

.right {
    transform: rotateY(90deg) translateZ(50px);
}

.left {
    transform: rotateY(-90deg) translateZ(50px);
}

.top {
    transform: rotateX(90deg) translateZ(50px);
}

.bottom {
    transform: rotateX(-90deg) translateZ(50px);
}

@keyframes rotate {
    from {
        transform: rotateX(0deg) rotateY(0deg);
    }
    to {
        transform: rotateX(360deg) rotateY(360deg);
    }
}
    </style>
</head>
<body>
    <div class="container">
        <div class="cube">
            <div class="face front">4</div>
            <div class="face back">0</div>
            <div class="face right">4</div>
            <div class="face left"></div>
            <div class="face top"></div>
            <div class="face bottom"></div>
        </div>
        <h1>Oops! Page Not Found</h1>
        <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="/" class="home-button">Go to Home</a>
    </div>
</body>
</html>