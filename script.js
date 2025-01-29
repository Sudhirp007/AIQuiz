document.addEventListener('DOMContentLoaded', function () {
    let currentQuestionId;
    let timer;
    const timeLimit = 15;
    
    const backupQuestions = [
        { id: 101, question: "What is 2 + 2?", options: { A: "3", B: "4", C: "5", D: "6" }, correct_option: "B" },
        { id: 102, question: "What is the capital of India?", options: { A: "Mumbai", B: "Delhi", C: "Kolkata", D: "Chennai" }, correct_option: "B" },
        { id: 103, question: "Which planet is known as the Red Planet?", options: { A: "Earth", B: "Venus", C: "Mars", D: "Jupiter" }, correct_option: "C" },
        { id: 104, question: "What is the largest mammal?", options: { A: "Elephant", B: "Blue Whale", C: "Giraffe", D: "Rhino" }, correct_option: "B" },
        { id: 105, question: "Who wrote the Harry Potter series?", options: { A: "J.R.R. Tolkien", B: "J.K. Rowling", C: "George R.R. Martin", D: "Agatha Christie" }, correct_option: "B" }
    ];

    function startTimer() {
        let timeLeft = timeLimit;
        const timerElement = document.getElementById('time-left');
        if (!timerElement) return;
        timerElement.innerText = timeLeft;
        timer = setInterval(() => {
            timeLeft--;
            timerElement.innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timer);
                alert('Time is up! Moving to the next question.');
                fetchQuestion();
            }
        }, 1000);
    }

    function fetchQuestion() {
        fetch('quiz.php')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (!data.success) throw new Error(data.error);
                handleQuestionData(data.data);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading question. Using a backup question.');
                useBackupQuestion();
            });
    }

    function useBackupQuestion() {
        const randomBackup = backupQuestions[Math.floor(Math.random() * backupQuestions.length)];
        handleQuestionData(randomBackup);
    }

    function handleQuestionData(data) {
        currentQuestionId = data.id;
        document.getElementById('question').textContent = data.question;
        const optionsDiv = document.getElementById('options');
        optionsDiv.innerHTML = '';
        for (const [key, value] of Object.entries(data.options)) {
            const label = document.createElement('label');
            label.innerHTML = `<input type="radio" name="answer" value="${key}"> ${value}`;
            optionsDiv.appendChild(label);
        }
        clearInterval(timer);
        startTimer();
    }

    document.getElementById('start-quiz').addEventListener('click', function () {
        fetchQuestion();
        this.disabled = true;
    });

    document.getElementById('next-question').addEventListener('click', function (e) {
        e.preventDefault();
        const selectedAnswer = document.querySelector('input[name="answer"]:checked');
        if (selectedAnswer) {
            fetch('submit_response.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: 1, question_id: currentQuestionId, selected_answer: selectedAnswer.value })
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchQuestion();
                })
                .catch(error => {
                    console.error('Error submitting response:', error);
                    alert('Error submitting response: ' + error.message);
                });
        } else {
            alert('Please select an answer!');
        }
    });

    fetchQuestion();
});
