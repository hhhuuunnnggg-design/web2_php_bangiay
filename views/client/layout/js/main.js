(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(window).width() < 992) {
            if ($(this).scrollTop() > 55) {
                $('.fixed-top').addClass('shadow');
            } else {
                $('.fixed-top').removeClass('shadow');
            }
        } else {
            if ($(this).scrollTop() > 55) {
                $('.fixed-top').addClass('shadow').css('top', -55);
            } else {
                $('.fixed-top').removeClass('shadow').css('top', 0);
            }
        } 
    });
    
    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:2
            },
            1200:{
                items:2
            }
        }
    });


    // vegetable carousel
    $(".vegetable-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });



    // Product Quantity
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });

})(jQuery);

document.addEventListener('DOMContentLoaded', function() {
    // Load brands
    fetch('/shoeimportsystem/index.php?controller=brand&action=getBrands')
        .then(response => response.json())
        .then(brands => {
            const companyMenu = document.querySelector('.companyMenu');

            brands.forEach(brand => {
                let brandLink = document.createElement('a');
                brandLink.href = "#";
                brandLink.className = "dropdown-item";
                brandLink.textContent = brand.TenNCC;
                brandLink.dataset.id = brand.MaNCC;

                // Khi click vào thương hiệu
                brandLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    loadProductsByBrand(brand.MaNCC);
                });

                companyMenu.appendChild(brandLink);
            });
        });

    // Load sản phẩm theo brand
    function loadProductsByBrand(brandId) {
        fetch(`/shoeimportsystem/index.php?controller=brand&action=getProductsByBrand&id=${brandId}`)
            .then(response => response.json())
            .then(products => {
                const productList = document.getElementById('productList');
                productList.innerHTML = '';

                if (products.length > 0) {
                    products.forEach(product => {
                        let productDiv = document.createElement('div');
                        productDiv.innerHTML = `
                            <h4>${product.TenSP}</h4>
                            <p>Giá: ${product.Gia} VNĐ</p>
                            <img src="${product.HinhAnh}" alt="${product.TenSP}" width="100">
                            <hr>
                        `;
                        productList.appendChild(productDiv);
                    });
                } else {
                    productList.innerHTML = "<p>Không có sản phẩm nào!</p>";
                }
            });
    }
});
