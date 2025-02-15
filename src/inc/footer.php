<style>
    <?php include 'css/footer.css' ?>
</style>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!--cookies logic-->
<div id="cookiePopup" style="display: none; position: fixed; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: darkgrey; text-align: center; border-top: 1px solid #ddd;">
    This website uses cookies, please accept them before proceeding to any other page.
    <button onclick="acceptCookies()" style="width: 5%; color:black;">Accept</button>
</div>
<script>
    function acceptCookies() {
        document.getElementById('cookiePopup').style.display = 'none';
        document.cookie = "cookiesAccepted=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
    }

    if (document.cookie.indexOf("cookiesAccepted=true") === -1) {
        document.getElementById('cookiePopup').style.display = 'block';
    }
</script>
<!--cookies logic-->

</body>
<footer class="bg-dark text-light py-4">
        </div>
        <div class="row" style="color: white; font-weight: bold; padding-top: 10px">
            <div class="col-md-6">
                <div class="footer-info">
                    <a href="#" style="color:black;"><span style="border: 1px solid black; padding:2px"><i class="fas fa-arrow-up"></i>Scroll up</span></a>
                    <small style="color:black; border: 1px solid black; padding:2px">Copyright 2025 &copy; DETAILS, <time datetime="2025-02-12">12 February 2025 - This is a school project. </time></small>
                </div>
            </div>
        </div>
    </div>
</footer>
</html>