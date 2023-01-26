<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}
 
if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}
 

function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
} 

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?> 

.pagination .page-item.active .page-link, .pagination .page-item:hover .page-link,
.bg--base, .banner-content .sub-title::before, .btn--base, .badge-circle, .section-header .section-title::before, .section-header .section-title::after, .footer-social li:hover, .scrollToTop, .submit-btn, .timeline .timeline-item.complete > .timeline-point.blk-point, .blog-social-area .blog-social li:hover, .contact-info-icon i, .custom-table thead tr th, button.cmn--btn:hover, *::selection, .footer-bottom-area::after, .custom--card .card-header{
    background-color: <?php echo $color; ?>;
}
.mobile-menu li a.active, .navbar-collapse .main-menu li a.active, .text--base, .product-details-content .product-ratings, .overview-icon, .blog-content .title a:hover, .timeline .timeline-item .timeline-time p, .timeline .timeline-item > .timeline-point.blk-point ~ .timeline-event, .product-single-tab .nav-tabs .nav-item .nav-link.active{
    color: <?php echo $color; ?>;
} 
  
.info-icon { 
    background-color: <?php echo $color; ?>;cc;
    box-shadow: 0px 0px 10px 0 <?php echo $color; ?>;ccb3;
}
 
.btn--base:focus, .btn--base:hover{
    background-color: <?php echo $secondColor; ?>;
} 

.timeline-item.complete::after {
    border-right-color: <?php echo $color; ?>cc;
}
.pagination .page-item.active .page-link, .pagination .page-item:hover .page-link {
    border-color: <?php echo $color?>;
}
  
.add-cart-box {
    border-top: 4px solid <?php echo $color; ?>cc;
}
.bg--base,
.bg--base:hover,
.cmn--btn, 
*::-webkit-scrollbar-button,
*::-webkit-scrollbar-thumb {
  background-color: <?php echo $color; ?>;
}

.loader::before {
  box-shadow: 18px 18px #0077b6, -18px -18px #2a9d8f;
}

.loader::after {
  box-shadow: 18px 18px <?php echo $color; ?>, -18px -18px <?php echo $secondColor; ?>;
  transform: translate(-50%, -50%) rotate(90deg);
}

.footer-bottom-area::before{
    background-color: <?php echo $color; ?>10;
}

.product-single-tab .nav-tabs .nav-item .nav-link.active{
    border-color: <?php echo $color; ?>;
}

.config-size-list input:checked ~ label {
    background: <?php echo $color?>;
    border-color: <?php echo $color?>;
}

.loader::before {
  box-shadow: 18px 18px #0077b6, -18px -18px #2a9d8f;
}

.loader::after {
  box-shadow: 18px 18px <?php echo $color; ?>, -18px -18px <?php echo $secondColor; ?>;
  transform: translate(-50%, -50%) rotate(90deg);
}

.loader::before {
  box-shadow: 18px 18px <?php echo $color; ?>, -18px -18px <?php echo $color; ?>;
}

.loader::after {
  box-shadow: 18px 18px <?php echo $secondColor; ?>, -18px -18px <?php echo $secondColor; ?>;
  transform: translate(-50%, -50%) rotate(90deg);
}