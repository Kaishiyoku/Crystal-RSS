@section('title', __('user.emails.new_email.title'))

<p>
    {{ __('profile.emails.new_email.you_have_changed_your_email_and_must_confirm_it') }}
</p>

<p>
    {{ __('profile.emails.new_email.new_email_address', ['email' => $newEmail]) }}
</p>

<p>
    {{ Html::linkRoute('profile.confirm_new_email', null, [$newEmailToken]) }}
</p>