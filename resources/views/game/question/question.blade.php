<div>
<p> A question from Player 2. </p>
    <form method="POST" action="{{ route('game.answer_question', $question->id) }}">
        <div class="form-group">
            <div>
                <label> {{ $question->question }} </label>

                <label for="yes">
                    <input id="yes" name="answer" value="yes" type="radio">
                    Yes
                </label>

                <label for="no">
                    <input id="no" name="answer" value="no" type="radio">
                    No
                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>
    </form>
</div>
