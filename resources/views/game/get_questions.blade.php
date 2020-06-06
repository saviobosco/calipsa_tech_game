@foreach($questions as $question)

    <ul>
        <li> {{ $question->question }} </li>
    </ul>

@endforeach
