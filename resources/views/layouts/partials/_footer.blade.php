<section class="footer footer-dark bg-dark text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-sm-4 mb-md-0">
                <h3>{{ config('app.name') }}</h3>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum excepturi magni nobis nulla
                    obcaecati sapiente, veritatis. Dolor dolorum eligendi eos esse, eum illo, labore necessitatibus
                    nemo praesentium repellendus rerum sunt.
                </p>

                <p>
                    &copy; {{ now()->year }} {{ config('app.name') }}. {{ __('All Rights Reserved') }}.
                </p>
            </div>

            <div class="col-md-3 mb-sm-4 mb-md-0">
                <h4>Quick Links</h4>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('plans.index') }}">{{ __('Plans') }}</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                    @endguest

                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Support') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Terms of Service') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-sm-4 mb-md-0">
                <h4>{{ __('Resources') }}</h4>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Blog') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Documentation') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('API') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h4>{{ __('Newsletter Subscription') }}</h4>

                <p>Be the first to know about new features, tips and much more...</p>

                <form action="#" class="my-2 my-lg-0">
                    <div class="form-group">
                        <input class="form-control"
                               type="email"
                               placeholder="Your email address..."
                               aria-label="{{ __('Email Address') }}">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="submit">
                            {{ __('Yes, Sign Me Up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
