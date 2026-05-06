(function () {

    "use strict";

    document.addEventListener("DOMContentLoaded", function () {

        /**
         * Apply .scrolled class to the body as the page is scrolled down
         */
        function toggleScrolled() {

            const selectBody = document.querySelector('body');
            const selectHeader = document.querySelector('#header');

            if (!selectHeader) return;

            if (
                !selectHeader.classList.contains('scroll-up-sticky') &&
                !selectHeader.classList.contains('sticky-top') &&
                !selectHeader.classList.contains('fixed-top')
            ) return;

            window.scrollY > 100
                ? selectBody.classList.add('scrolled')
                : selectBody.classList.remove('scrolled');

            const stickyDiv = document.querySelector(".sticky-div");
            const categoryDiv = document.querySelector('#categoryDiv');
            const searchDivRight = document.querySelector('#searchDivRight');
            const headerHeight = selectHeader.offsetHeight;

            if (stickyDiv && categoryDiv && searchDivRight && window.scrollY > 100) {

                categoryDiv.classList.remove("col-lg-12");
                categoryDiv.classList.add("col-lg-7");

                searchDivRight.style.display = "block";

                selectHeader.style.boxShadow = "none";
                selectHeader.classList.remove("border-bottom");

                stickyDiv.classList.add("sticky-fixed");
                stickyDiv.style.position = "fixed";
                stickyDiv.style.top = `${headerHeight}px`;

            } else {

                if (categoryDiv) {
                    categoryDiv.classList.remove("col-lg-7");
                    categoryDiv.classList.add("col-lg-12");
                }

                if (searchDivRight) {
                    searchDivRight.style.display = "none";
                }

                selectHeader.classList.add("border-bottom");

                if (stickyDiv) {
                    stickyDiv.classList.remove("sticky-fixed");
                    stickyDiv.style.position = "relative";
                    stickyDiv.style.top = "initial";
                }
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

            if (mobileNavToggleBtn) {
                mobileNavToggleBtn.classList.toggle('bi-list');
                mobileNavToggleBtn.classList.toggle('bi-x');
            }
        }

        if (mobileNavToggleBtn) {
            mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
        }

        /**
         * Hide mobile nav on same-page/hash links
         */
        const navLinks = document.querySelectorAll('#navmenu a');
        if (navLinks.length > 0) {
            navLinks.forEach(navmenu => {
                navmenu.addEventListener('click', () => {
                    if (document.querySelector('.mobile-nav-active')) {
                        mobileNavToogle();
                    }
                });
            });
        }

        /**
         * Toggle mobile nav dropdowns
         */
        const dropdownToggles = document.querySelectorAll('.navmenu .toggle-dropdown');
        if (dropdownToggles.length > 0) {
            dropdownToggles.forEach(navmenu => {
                navmenu.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (this.parentNode) {
                        this.parentNode.classList.toggle('active');
                        if (this.parentNode.nextElementSibling) {
                            this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
                        }
                    }
                    e.stopImmediatePropagation();
                });
            });
        }

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
         * FAQ Toggle
         */
        const faqItems = document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle');
        if (faqItems.length > 0) {
            faqItems.forEach((faqItem) => {
                faqItem.addEventListener('click', () => {
                    if (faqItem.parentNode) {
                        faqItem.parentNode.classList.toggle('faq-active');
                    }
                });
            });
        }

        /**
         * Scroll to hash properly
         */
        window.addEventListener('load', function () {
            if (window.location.hash) {
                const section = document.querySelector(window.location.hash);
                if (section) {
                    setTimeout(() => {
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
        const navmenulinks = document.querySelectorAll('.navmenu a');

        function navmenuScrollspy() {
            navmenulinks.forEach(navmenulink => {

                if (!navmenulink.hash) return;

                let section = document.querySelector(navmenulink.hash);
                if (!section) return;

                let position = window.scrollY + 200;

                if (
                    position >= section.offsetTop &&
                    position <= (section.offsetTop + section.offsetHeight)
                ) {
                    document.querySelectorAll('.navmenu a.active')
                        .forEach(link => link.classList.remove('active'));

                    navmenulink.classList.add('active');
                } else {
                    navmenulink.classList.remove('active');
                }
            });
        }

        window.addEventListener('load', navmenuScrollspy);
        document.addEventListener('scroll', navmenuScrollspy);

        /**
         * Become Service Provider
         */
        window.addEventListener('click', function (e) {

            if (e.target.matches('#becomeServiceProvider')) {

                e.preventDefault();

                let id = e.target.getAttribute('data-id');

                if (typeof $ !== "undefined" && $.easyDelete) {
                    $.easyDelete({
                        url: route('switch.user-profile', { user: id }),
                        type: 'POST',
                        confirmationMessage: 'Do you really want to become Service Provider ?',
                        confirmationButtonText: 'Yes, want to switch!',
                        onComplete: () => {
                            window.location.href = route('frontend.business-listings.createOrUpdate');
                        }
                    });
                }
            }
        });

    });

})();
