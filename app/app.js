$(document).ready(function(){
    $('#app-navbar').html(getNavbar());

    $('#app-footer').html(getFooter());

});

// change page title
function changePageTitle(page_title){

    // change page title
    $('#page-title').text(page_title);

    // change title tag
    document.title=page_title;
}

function getNavbar(){
    return `
        <nav class="navbar navbar-expand-lg navbar-light fd-navbar">
            <div class="container">
                <a class="navbar-brand" href="#">FINE DINING</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Help</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    `;
}

function getFooter(){
    return `
        <div class="fd-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="fd-footer-heading">Customer Support</h2>
                        <ul class="list-unstyled">
                            <li><a href="#"><i class="bi-alarm"></i>Contact us</a></li>
                            <li><a href="#">Log in</a></li>
                            <li><a href="#">Sign up</a></li>
                            <li><a href="#">My account</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h2 class="fd-footer-heading">Top Cuisines</h2>
                        <ul class="list-unstyled">
                            <li><a href="#">Thai</a></li>
                            <li><a href="#">Chinese</a></li>
                            <li><a href="#">Indian</a></li>
                            <li><a href="#">American</a></li>
                            <li><a href="#">Pizza</a></li>
                            <li><a href="#">Sushi</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h2 class="fd-footer-heading">Social Media</h2>
                        <ul class="list-unstyled">
                            <li><a href="#"><i class="bi bi-facebook"></i> Facebook</a></li>
                            <li><a href="#"><i class="bi bi-instagram"></i> Instagram</a></li>
                            <li><a href="#"><i class="bi bi-twitter"></i> Twitter</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center fd-footer-copyright">
                        <p>
                            Copyright &copy;` + new Date().getFullYear() + ` All rights reserved</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

