<section class="content-header">
    <h1>
        {{ $title }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

        @if ($li_1 != 'Dashboard')
            <li><a href="#">{{ $li_1 }}</a></li>
        @endif
        @if (isset($li_2))
            <li class="active">{{ $li_2 }}</li>
        @endif
    </ol>
</section>
