<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('BD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Black Dashboard') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'history') class="active " @endif>
                <a href="{{ route('history.page') }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>{{ __('History') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'calculation') class="active " @endif>
                <a href="{{ route('calculation.page') }}">
                    <i class="tim-icons icon-laptop"></i>
                    <p>{{ __('Cost Calculation') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'upload') class="active " @endif>
                <a href="{{ route('data.page') }}">
                    <i class="tim-icons icon-upload"></i>
                    <p>{{ __('Upload') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'device') class="active " @endif>
                <a href="{{ route('add-device.page') }}">
                    <i class="tim-icons icon-simple-add"></i>
                    <p>{{ __('Add device') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
