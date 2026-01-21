/**
 * Template Name: Bootslander
 * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
 * Updated: Aug 07 2024 with Bootstrap v5.3.3
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */

(function() {



    "use strict";

    /**
     * Apply .scrolled class to the body as the page is scrolled down
     */
    function toggleScrolled() {
        const selectBody = document.querySelector('body');
        const selectHeader = document.querySelector('#header');
        if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
        window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
        const stickyDiv = document.querySelector(".sticky-div");
        const categoryDiv = document.querySelector('#categoryDiv');
        const searchDivRight = document.querySelector('#searchDivRight');
        const headerHeight = selectHeader.offsetHeight;
        if (stickyDiv && window.scrollY > 100) {
            categoryDiv.classList.remove("col-lg-12");
            categoryDiv.classList.add("col-lg-7");
            searchDivRight.style.display = "block";
            selectHeader.style.boxShadow = "none";
            selectHeader.classList.remove("border-bottom");
            stickyDiv.classList.add("sticky-fixed");
            stickyDiv.style.position = "fixed";
            stickyDiv.style.top = `${headerHeight}px`;
        } else {
            categoryDiv.classList.remove("col-lg-7");
            categoryDiv.classList.add("col-lg-12");
            searchDivRight.style.display = "none";
            selectHeader.classList.add("border-bottom");
            stickyDiv.classList.remove("sticky-fixed");
            stickyDiv.style.position = "relative";
            stickyDiv.style.top = "initial";
        }
    }




    document.addEventListener('scroll', toggleScrolled);
    window.addEventListener('load', toggleScrolled);

    /**
     * Mobile nav toggle
     */
    const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

    function mobileNavToogle() {
        document.querySelector('body').classList.toggle('mobile-nav-active');
        mobileNavToggleBtn.classList.toggle('bi-list');
        mobileNavToggleBtn.classList.toggle('bi-x');
    }
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);


    /**
     * Hide mobile nav on same-page/hash links
     */
    document.querySelectorAll('#navmenu a').forEach(navmenu => {
        navmenu.addEventListener('click', () => {
            if (document.querySelector('.mobile-nav-active')) {
                mobileNavToogle();
            }
        });

    });

    /**
     * Toggle mobile nav dropdowns
     */
    document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
        navmenu.addEventListener('click', function(e) {
            e.preventDefault();
            this.parentNode.classList.toggle('active');
            this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
            e.stopImmediatePropagation();
        });
    });

    /**
     * Preloader
     */
    const preloader = document.querySelector('#preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.remove();
        });
    }



    /**
     * Frequently Asked Questions Toggle
     */
    document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
        faqItem.addEventListener('click', () => {
            faqItem.parentNode.classList.toggle('faq-active');
        });
    });

    /**
     * Correct scrolling position upon page load for URLs containing hash links.
     */
    window.addEventListener('load', function(e) {
        if (window.location.hash) {
            if (document.querySelector(window.location.hash)) {
                setTimeout(() => {
                    let section = document.querySelector(window.location.hash);
                    let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
                    window.scrollTo({
                        top: section.offsetTop - parseInt(scrollMarginTop),
                        behavior: 'smooth'
                    });
                }, 100);
            }
        }
    });



    /**
     * Navmenu Scrollspy
     */
    let navmenulinks = document.querySelectorAll('.navmenu a');

    function navmenuScrollspy() {
        navmenulinks.forEach(navmenulink => {
            if (!navmenulink.hash) return;
            let section = document.querySelector(navmenulink.hash);
            if (!section) return;
            let position = window.scrollY + 200;
            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
                navmenulink.classList.add('active');
            } else {
                navmenulink.classList.remove('active');
            }
        })
    }
    window.addEventListener('load', navmenuScrollspy);
    document.addEventListener('scroll', navmenuScrollspy);

    /**
     * To Become Service Provider
     */
    window.addEventListener('click', function (e) {
        if (e.target.matches('#becomeServiceProvider')) {
            e.preventDefault(); // Prevent default anchor behavior
            let id = e.target.getAttribute('data-id'); // Get user ID
            $.easyDelete({
                url: route('switch.user-profile', {user: id}),
                type:'POST',
                confirmationMessage: 'Do you really want to become Service Provider ?',
                confirmationButtonText: 'Yes, want to switch!',
                onComplete: () => {
                    window.location.href = route('frontend.business-listings.createOrUpdate');
                }
            });
        }
    });



})();
