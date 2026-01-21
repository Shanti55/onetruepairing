@extends('frontend.layouts.app')

@section('title', 'Blogs | CtrlF')

@section('content')
    <div xmlns="http://www.w3.org/1999/html">
        <div class="container-fluid p-0 m-0">
            <main class="main bg-white">

                <!-- About Section-->
                <!-- Featured Service Providers Section -->
                <section id="featured-provider" class="team section light-background">

                    <!-- Section Title -->
                    <div class="container w-100" data-aos="fade-up" style="padding-bottom: 0!important;">
                        <div class="blog-content-wrapper">
                            <div class="header-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="fw-bold text-dark"><a href="{{ route('frontend.blogs') }}" class="text-dark"><i class="bi bi-arrow-left-circle me-2"></i><span class="description-title">{{ 'Back to blogs' }}</span></a></h4>
                                    <h4 class="fw-bold">Blog</h4>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Section Title -->

                    <div class="container">
                       <div class="blog-content-wrapper">
                           @if($blog)
                               <div class="header-content">
                                   <div class="article-media">
                                       @if ($blog->media)
                                           @if (Str::endsWith($blog->media, ['.jpg', '.jpeg', '.png']))
                                               <img src="{{ $blog->media }}" class="rounded-4" alt="Blog Image"  loading="lazy">
                                           @elseif (Str::endsWith($blog->media, ['.mp4', '.mov', '.avi']))
                                               <video class="rounded-4 w-100" controls>
                                                   <source src="{{ $blog->media }}" type="video/mp4">
                                               </video>
                                           @endif
                                       @endif
                                   </div>
                               </div>
                               <div class="article-content">
                                   <div class="card border-0">
                                       <div class="card-body">
                                           <h1 class="card-title mb-2 text-center fw-bold">{{ $blog->title }}</h1>
                                           <div class="d-flex justify-content-center align-items-center">
{{--                                               <p class="text-muted mb-2 d-flex gap-2 justify-content-center align-items-center">--}}
{{--                                                   <img src="https://avataaars.io/?avatarStyle=Circle&topType=ShortHairShortFlat&accessoriesType=Blank&hairColor=Black" alt="{{ $blog->postedBy->name }}" width="50" style="width: 50px!important;">--}}
{{--                                                   <span>By <span class="fw-bold text-primary">{{ ucwords($blog->postedBy->name) }}</span></span>--}}
{{--                                               </p>--}}
                                               <p class="text-muted">
                                                   {{ $blog->created_at->format('d M Y H:i a') }}
                                               </p>
                                           </div>

                                           <hr>
                                           <div class="blog-content">
                                               {!! $blog->content !!}
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           @else
                               <div class="alert alert-warning text-center" role="alert">
                                   <h4 class="alert-heading">Blog not found</h4>
                                   <p>Sorry, the blog you’re looking for doesn’t exist or has been removed.</p>
                               </div>
                           @endif
                           <div class="mt-4 text-end">
                               <a href="{{ route('frontend.blogs') }}" class="btn btn-dark">Back to Blogs</a>
                           </div>
                       </div>

                </div>
                </section>
            </main>
        </div>
    </div>
@endsection
