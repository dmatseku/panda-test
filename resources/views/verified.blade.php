@if ($email !== false)
    <h2>The Email {{$email}} has been verified</h2>
@else
    <h2>Invalid confirmation url</h2>
@endif