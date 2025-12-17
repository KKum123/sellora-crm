<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 - Access Denied</title>
  <style>
/* styles.css */
body {
  font-family: 'Arial', sans-serif;
  background: linear-gradient(135deg, #1e3c72, #2a5298);
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
  overflow: hidden;
}

.container {
  text-align: center;
}

.line-animation {
  width: 80%;
  max-width: 500px;
  margin: 0 auto 20px;
}

.path {
  stroke: #ff4b5c; /* Color of the line */
  stroke-dasharray: 1000; /* Length of the dash pattern */
  stroke-dashoffset: 1000; /* Offset to hide the line initially */
  animation: draw 3s ease-in-out forwards, glow 2s infinite alternate;
}

@keyframes draw {
  to {
    stroke-dashoffset: 0; /* Reveal the line */
  }
}

@keyframes glow {
  0% {
    stroke: #ff4b5c;
    filter: drop-shadow(0 0 5px #ff4b5c);
  }
  100% {
    stroke: #e43a4a;
    filter: drop-shadow(0 0 20px #ff4b5c);
  }
}

.access-denied {
  font-size: 2.5rem;
  margin-bottom: 10px;
  opacity: 0;
  animation: fadeIn 1s ease-in-out 3s forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
  }
}

p {
  font-size: 1.2rem;
  margin-bottom: 20px;
  opacity: 0;
  animation: fadeIn 1s ease-in-out 3.5s forwards;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #ff4b5c;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  opacity: 0;
  animation: fadeIn 1s ease-in-out 4s forwards, pulse 2s infinite 4s;
}

.btn:hover {
  background-color: #e43a4a;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}
  </style>
</head>
<body>
    <div class="container">
        <svg class="line-animation" viewBox="0 0 500 100">
          <!-- Define the path for the line -->
          <path class="path" d="M10 50 Q250 10 490 50" fill="transparent" stroke-width="4" />
        </svg>
        <h1 class="access-denied">403 - Access Denied</h1>
        <p>You don’t have permission to view this page.</p>
        <a href="/team/auth/login" class="btn">Go Back to Home</a>
      </div>
  
</body>
<script>
 
</html>