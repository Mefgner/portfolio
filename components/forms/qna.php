<form method="POST" action="actions/create_question.php" class="qna-form">
    <div class="form-group">
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required class="form-control">
    </div>

    <div class="form-group">
        <label for="question">Your Question:</label>
        <textarea id="question" name="question" rows="4" required class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit Question</button>
</form>
