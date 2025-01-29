<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="landing-page">
        <h1>Welcome to the Ultimate Quiz Challenge!</h1>
        <p>Test your knowledge and see where you stand among top players.</p>
        <button id="start-quiz">Start Quiz</button>
        <div class="leaderboard">
            <h2>Leaderboard</h2>
            <ul id="leaderboard-list">Loading...</ul>
        </div>
    </div>
    
    <div class="quiz-container hidden">
        <h1>Quiz Time</h1>
        <div id="quiz-box">
            <p id="question">Loading question...</p>
            <div id="options"></div>
            <div class="timer">Time left: <span id="time-left">30</span> sec</div>
            <button id="next-question" class="hidden">Next Question</button>
        </div>
    </div>
    
    <div class="doubt-section">
        <h2>Ask a Doubt</h2>
        <input type="text" id="doubt-input" placeholder="Type your doubt here...">
        <button id="send-doubt">Ask AI</button>
        <div id="doubt-response"></div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>