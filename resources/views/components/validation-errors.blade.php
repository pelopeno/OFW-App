@if ($errors->any())
<div {{ $attributes }}>
    @foreach ($errors->all() as $error)
    <p class="error-desc">{{ $error }}</p>
    @endforeach
    <br>
</div>
@endif

<style>
    .error-desc {
        margin: 0;
        text-align: center;
        font-family: "Varela Round";
        color: #b31e20;
    }
</style>