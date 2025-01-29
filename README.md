# AIQuiz
Website supported by AI features
# Quiz Website Deployment Instructions

## Prerequisites
- PHP 7.3 or higher
- OpenRouterAI API key
- Basic knowledge of PHP and JavaScript

## Deployment Steps

1. **Install a local server**: Use XAMPP or WAMP to set up a local server on your machine.
2. **Create a project directory**: Inside the `htdocs` (XAMPP) or `www` (WAMP) directory, create a folder named `quiz-website`.
3. **Place files in the directory**: Copy all the files (`index.php`, `quiz.php`, `ask_doubt.php`, `styles.css`, `scripts.js`, `README.md`) into the `quiz-website` folder.
4. **Replace API key**: Open `ask_doubt.php` and replace `'YOUR_OPENROUTERAI_API_KEY'` with your actual OpenRouterAI API key.
5. **Start your local server**: Ensure XAMPP or WAMP is running.
6. **Open your project**: Navigate to `http://localhost/quiz-website` in your web browser.
7. **Test the quiz**: Select an option and submit it. Enter a doubt and click "Send" to see the response from the OpenRouterAI API.

## Notes
- **Database Integration**: To pull questions from a database, you can modify `quiz.php` to query a MySQL database.
- **Security**: Ensure you handle user input securely to prevent SQL injection and other vulnerabilities.
- **API Key Management**: Store your API key securely and avoid hardcoding it directly into your PHP script.
