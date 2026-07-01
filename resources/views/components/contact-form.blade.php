@props(['services'])
<div class="reveal min-w-0 rounded-xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/[.03] sm:p-8 lg:p-10" data-reveal>
    @if(session('success'))<div class="mb-7 rounded-md border-l-4 border-emerald-500 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="mb-7 rounded-md border-l-4 border-coral bg-red-50 p-4 text-sm text-red-800">Merci de corriger les champs signalés.</div>@endif
    <form action="{{ route('contact.store') }}" method="POST" class="grid gap-5 sm:grid-cols-2">@csrf
        <div class="sm:col-span-2"><label class="form-label" for="full_name">Nom complet *</label><input class="form-input" id="full_name" name="full_name" value="{{ old('full_name') }}" autocomplete="name" required>@error('full_name')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label" for="email">E-mail *</label><input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label" for="phone">Téléphone</label><input class="form-input" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"></div>
        <div><label class="form-label" for="company">Société</label><input class="form-input" id="company" name="company" value="{{ old('company') }}" autocomplete="organization"></div>
        <div><label class="form-label" for="service">Service souhaité</label><select class="form-input" id="service" name="service"><option value="">À préciser</option>@foreach($services as $item)<option @selected(old('service', request('service')) === $item->title)>{{ $item->title }}</option>@endforeach<option @selected(old('service') === 'Autre')>Autre</option></select></div>
        <div class="sm:col-span-2"><label class="form-label" for="message">Message *</label><textarea class="form-input min-h-36" id="message" name="message" required>{{ old('message') }}</textarea>@error('message')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div class="sm:col-span-2"><x-button-primary type="submit" class="w-full sm:w-auto">Envoyer la demande</x-button-primary><p class="mt-4 text-xs leading-5 text-slate-400">En envoyant ce formulaire, vous acceptez notre <a class="underline hover:text-coral" href="{{ route('confidentialite') }}">politique de confidentialité</a>.</p></div>
    </form>
</div>
