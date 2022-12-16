<!--begin:Menu Tree item-->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">
           {{$icon ?? ''}}
        </span>
        <span class="menu-title">{{$title ?? ''}}</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        {{$sub_item ?? '' }}
    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu Tree item-->
