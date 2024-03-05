<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">



        @if (Auth::user()->role == 'admin')
            {{-- Category & News --}}
            <li class="nav-item">
                <a class="nav-link " href="{{ route('home') }}">
                    <i class="bi bi-grid"></i>
                    <span>Home</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @else
        @endif

        <li class="nav-item">
            <a class="nav-link " href="{{ route('category.index') }}">
                <i class="bi bi-basket2"></i>
                <span>Category</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link " href="{{ route('news.index') }}">
                <i class="bi bi-basket2"></i>
                <span>News</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="nav-item">

        </li><!-- End Blank Page Nav -->

    </ul>

</aside>
