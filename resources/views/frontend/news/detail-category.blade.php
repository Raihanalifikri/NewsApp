@extends('frontend.parent')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9" data-aos="fade-up">
                    <h3 class="category-title">Category: {{ $detailCategory->name }}</h3>

                    @foreach ($detailCategory->news as $news)
                        <div class="d-md-flex post-entry-2 half">
                            <a href="{{ route('detailNews', $news->slug) }}" class="me-4 thumbnail">
                                <img src="{{ $news->image }}" alt="" class="img-fluid">
                            </a>
                            <div>
                                <div class="post-meta"><span class="date">{{ $news->category->name }}</span> <span
                                        class="mx-1">&bullet;</span> <span>{{ $news->created_at->diffForHumans() }}</span>
                                </div>
                                <h3><a href="{{ route('detailNews', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p>{{ Str::limit(strip_tags($news->content, 100)) }}
                                </p>
                                <div class="d-flex align-items-center author">
                                    <div class="photo"><img src="{{ asset('zen/assets/img/person-2.jpg') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="name">
                                        <h3 class="m-0 p-0">admin</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-3">


                    @foreach ($sideNews as $news)
                        <div class="post-entry-1 border-bottom">
                            <div class="post-meta"><span class="date">{{ $news->name }}</span> <span
                                    class="mx-1">&bullet;</span>
                                <span>{{ $news->created_at->diffForHumans() }}</span>
                            </div>
                            <h2 class="mb-2"><a href="{{ route('detailNews', $news->slug) }}">
                                    {{-- limit Character --}}
                                    {{ Str::limit($news->title, 30) }}</a></h2>
                            <span class="author mb-3 d-block">Admin</span>
                            <p>{{ Str::limit(strip_tags($news->content, 70)) }}</p>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
