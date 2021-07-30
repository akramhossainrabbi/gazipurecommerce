@extends('admin.layout.base')

@section('title', 'App Settings')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 text-gray-800">Settings</h1>
    </div>
    @if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    @if (Session::has('errors'))
    <span class="text-danger">{{ Session::get('errors') }}</span>
    @endif
    {{-- In work, do what you enjoy. --}}
    <div class="row user">
        <div class="col-md-3 mb-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="tile p-0">
                        <ul class="nav flex-column nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                            <li class="nav-item"><a class="nav-link" href="#site-logo" data-toggle="tab">Site Logo</a></li>
                            <li class="nav-item"><a class="nav-link" href="#footer-seo" data-toggle="tab">Footer &amp; SEO</a></li>
                            <li class="nav-item"><a class="nav-link" href="#social-links" data-toggle="tab">Social Links</a></li>
                            <li class="nav-item"><a class="nav-link" href="#analytics" data-toggle="tab">Analytics</a></li>
                            <li class="nav-item"><a class="nav-link" href="#payments" data-toggle="tab">Payments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    @include('admin.settings.general')
                </div>
                <div class="tab-pane fade" id="site-logo">
                    @include('admin.settings.logo')
                </div>
                <div class="tab-pane fade" id="footer-seo">
                    @include('admin.settings.footer_seo')
                </div>
                <div class="tab-pane fade" id="social-links">
                    @include('admin.settings.social_links')
                </div>
                <div class="tab-pane fade" id="analytics">
                    @include('admin.settings.analytics')
                </div>
                <div class="tab-pane fade" id="payments">
                    @include('admin.settings.payments')
                </div>
            </div>
        </div>
    </div>
@endsection 