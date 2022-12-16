<div class="card shadow-{{$shadowSize ?? 'sm'}} mb-{{$mb ?? '5'}} {{$cardClass ?? ''}}">
    @if(isset($title) || isset($action))
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                @isset($title)
                    <span class="card-label fw-bold fs-3 mb-1">{{$title}}</span>
                @endisset
                @isset($subTitle)
                    <span class="text-muted mt-1 fw-semibold fs-7">{{$subTitle}}</span>
                @endisset
            </h3>
            <div class="card-toolbar">
                {{$action ?? ''}}
            </div>
        </div>
    @endif
    @isset($body)
        <div class="card-body">
            {{$body}}
        </div>
    @endisset
    @isset($footer)
        <div class="card-footer">
            {{$footer}}
        </div>
    @endisset
</div>
