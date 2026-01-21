@extends('frontend.layouts.app')

@section('title', 'Blogs | CtrlF')

@section('content')
    <div class="container-fluid p-0 m-0">
        <main class="main">
            <section id="featured-provider" class="team section light-background">
                <div class="container section-title text-center w-50" data-aos="fade-up">
                    <h1 class="fw-bold"><span class="description-title">Blogs</span></h1>
                </div>

                <div class="container">
                    <div class="mb-4 text-center">
                        <input type="text" id="blog-search" class="form-control w-50 mx-auto" placeholder="Search blogs...">
                    </div>

                    <div class="row gy-4" id="blog-list">
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        const blogApiUrl = "{{ route('frontend.blogs.get-data') }}";

        document.addEventListener("DOMContentLoaded", function () {
            const blogList = document.getElementById('blog-list');
            const searchInput = document.getElementById('blog-search');

            function fetchBlogs(query = '') {
                fetch(`${blogApiUrl}?search=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(blogs => {
                        blogList.innerHTML = '';

                        if (blogs.length === 0) {
                            blogList.innerHTML = `
                            <div class="col-12 text-center">
                                <div class="alert alert-info" role="alert">
                                    <h4 class="alert-heading">No blogs available</h4>
                                    <p>Stay tuned for updates!</p>
                                </div>
                            </div>`;
                            return;
                        }

                        blogs.forEach(blog => {
                            const isImage = /\.(jpe?g|png)$/i.test(blog.media || '');
                            const isVideo = /\.(mp4|mov|avi)$/i.test(blog.media || '');

                            let mediaHTML = '';
                            if (isImage) {
                                mediaHTML = `<img src="${blog.media}" class="rounded-4 rounded-bottom-0 w-100" alt="Blog Image" loading="lazy" style="height: 200px; object-fit: cover;">`;
                            } else if (isVideo) {
                                mediaHTML = `<video class="rounded-4 w-100" height="200" controls>
                                            <source src="${blog.media}" type="video/mp4">
                                         </video>`;
                            }

                            blogList.innerHTML += `
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <a href="/blogs/${blog.id}" class="text-decoration-none text-dark">
                                    <div class="card h-100 shadow border-0 rounded-4">
                                        <div class="header-content">${mediaHTML}</div>
                                        <div class="card-body">
                                            <h5 class="text-dark fw-bolder">${blog.title}</h5>
                                            <p class="text-muted mb-1"><small>${new Date(blog.created_at).toLocaleString()}</small></p>
                                            <p class="card-text">${stripHtml(blog.content).slice(0, 100)}...</p>
                                        </div>
                                    </div>
                                </a>
                            </div>`;
                        });
                    });
            }

            function stripHtml(html) {
                let div = document.createElement("div");
                div.innerHTML = html;
                return div.textContent || div.innerText || "";
            }

            fetchBlogs(); // initial load

            searchInput.addEventListener('input', function () {
                fetchBlogs(this.value);
            });
        });
    </script>
@endsection
